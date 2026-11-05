<?php

require_once __DIR__ . '/../Core/Model.php';

class Reservation extends Model
{
    public function getAll()
    {
        $sql = "SELECT r.*, t.table_number, u.full_name AS staff_name
                FROM reservations r
                JOIN restaurant_tables t ON r.table_id = t.id
                JOIN users u ON r.user_id = u.id
                ORDER BY r.start_time DESC";

        $statement = $this->db->query($sql);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private $error = '';

    public function getError()
    {
        return $this->error;
    }

    private function validDetails($data)
    {
        if (trim($data['customer_name']) === '' || trim($data['customer_phone']) === '' ||
            strlen(trim($data['customer_name'])) > 100 ||
            strlen(trim($data['customer_phone'])) > 20 ||
            $data['table_id'] <= 0 || $data['guest_count'] <= 0) {
            $this->error = 'Please enter valid customer, table and guest details.';
            return false;
        }

        $start = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $data['start_time']);
        $end = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $data['end_time']);

        if (!$start || !$end ||
            $start->format('Y-m-d H:i') !== $data['start_time'] ||
            $end->format('Y-m-d H:i') !== $data['end_time']) {
            $this->error = 'Please select valid reservation dates and times.';
            return false;
        }

        if ($end <= $start) {
            $this->error = 'End time must be later than start time.';
            return false;
        }
        return true;
    }

    private function lockValidTable($tableId, $guestCount)
    {
        $stmt = $this->db->prepare(
            'SELECT capacity, is_active FROM restaurant_tables WHERE id = ? FOR UPDATE'
        );
        $stmt->execute([$tableId]);
        $table = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$table) {
            $this->error = 'The selected table does not exist.';
            return false;
        }
        if ((int) $table['is_active'] !== 1) {
            $this->error = 'This table is currently inactive.';
            return false;
        }
        if ($guestCount > (int) $table['capacity']) {
            $this->error = 'The number of guests exceeds the table capacity.';
            return false;
        }
        return true;
    }

    public function add($data)
    {
        $this->error = '';
        if (!$this->validDetails($data)) return false;

        try {
            $this->db->beginTransaction();
            if (!$this->lockValidTable($data['table_id'], $data['guest_count'])) {
                $this->db->rollBack();
                return false;
            }
            if (!$this->isTableAvailable($data['table_id'], $data['start_time'], $data['end_time'])) {
                $this->error = 'This table is already reserved for the selected time.';
                $this->db->rollBack();
                return false;
            }
            $stmt = $this->db->prepare(
                "INSERT INTO reservations (customer_name, customer_phone, table_id,
                  user_id, guest_count, start_time, end_time, status, notes)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'confirmed', ?)"
            );
            $result = $stmt->execute([
                trim($data['customer_name']), trim($data['customer_phone']),
                $data['table_id'], $data['user_id'], $data['guest_count'],
                $data['start_time'], $data['end_time'], trim($data['notes'])
            ]);
            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            $this->error = 'A database error occurred. Please try again.';
            return false;
        }
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM reservations WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $this->error = '';
        if ($id <= 0) {
            $this->error = 'Invalid reservation selected.';
            return false;
        }
        if (!$this->validDetails($data)) return false;

        try {
            $this->db->beginTransaction();
            if (!$this->lockValidTable($data['table_id'], $data['guest_count'])) {
                $this->db->rollBack();
                return false;
            }
            $existing = $this->getById($id);
            if (!$existing || $existing['status'] === 'cancelled') {
                $this->error = 'This reservation no longer exists or has been cancelled.';
                $this->db->rollBack();
                return false;
            }
            if (!$this->isTableAvailable($data['table_id'], $data['start_time'], $data['end_time'], $id)) {
                $this->error = 'This table is already reserved for the selected time.';
                $this->db->rollBack();
                return false;
            }
            $stmt = $this->db->prepare(
                "UPDATE reservations SET customer_name = ?, customer_phone = ?,
                  table_id = ?, guest_count = ?, start_time = ?, end_time = ?, notes = ?
                 WHERE id = ? AND status != 'cancelled'"
            );
            $stmt->execute([
                trim($data['customer_name']), trim($data['customer_phone']),
                $data['table_id'], $data['guest_count'], $data['start_time'],
                $data['end_time'], trim($data['notes']), $id
            ]);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            $this->error = 'A database error occurred. Please try again.';
            return false;
        }
    }

    public function cancel($id)
    {
        $sql = "UPDATE reservations
                SET status = 'cancelled'
                WHERE id = ? AND status != 'cancelled'";

        $statement = $this->db->prepare($sql);

        return $statement->execute([$id]) && $statement->rowCount() > 0;
    }

    public function isTableAvailable($tableId, $startTime, $endTime, $excludeId = 0)
    {
        $sql = "SELECT COUNT(*) FROM reservations
                WHERE table_id = ?
                AND status != 'cancelled'
                AND id != ?
                AND start_time < ?
                AND end_time > ?";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            $tableId,
            $excludeId,
            $endTime,
            $startTime
        ]);

        return $statement->fetchColumn() == 0;
    }

    
    public function search($keyword)
    {
        $sql = "SELECT r.*, t.table_number,
                    u.full_name AS staff_name
                FROM reservations r
                JOIN restaurant_tables t ON r.table_id = t.id
                JOIN users u ON r.user_id = u.id
                WHERE r.customer_name LIKE ?
                OR r.customer_phone LIKE ?
                OR t.table_number LIKE ?
                ORDER BY r.start_time DESC";

        $statement = $this->db->prepare($sql);

        $searchTerm = '%' . $keyword . '%';

        $statement->execute([
            $searchTerm,
            $searchTerm,
            $searchTerm
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function countToday()
    {
        $sql = "SELECT COUNT(*) FROM reservations
                WHERE DATE(start_time) = CURDATE()
                AND status != 'cancelled'";

        $statement = $this->db->query($sql);

        return $statement->fetchColumn();
    }



}
