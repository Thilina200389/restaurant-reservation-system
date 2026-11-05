<?php

require_once __DIR__ . '/../Core/Model.php';

class RestaurantTable extends Model
{
    public function getAll()
    {
        $sql = "SELECT * FROM restaurant_tables ORDER BY table_number";
        $statement = $this->db->query($sql);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($tableNumber, $capacity)
    {
        $tableNumber = trim($tableNumber);

        if ($tableNumber === '' || $capacity <= 0) {
            return false;
        }

        $sql = "INSERT INTO restaurant_tables
                (table_number, capacity)
                VALUES (?, ?)";

        $statement = $this->db->prepare($sql);

        try {
            return $statement->execute([$tableNumber, $capacity]);
        } catch (PDOException $e) {
            return false;
        }
    }

        public function toggleStatus($id)
    {
        $table = $this->getById($id);

        if (!$table) {
            return false;
        }

        $newStatus = $table['is_active'] == 1 ? 0 : 1;

        $sql = "UPDATE restaurant_tables
                SET is_active = ?
                WHERE id = ?";

        $statement = $this->db->prepare($sql);

        return $statement->execute([$newStatus, $id]);
    }

    
    public function getById($id)
    {
        $sql = "SELECT * FROM restaurant_tables WHERE id = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $tableNumber, $capacity)
    {
        $tableNumber = trim($tableNumber);

        if ($tableNumber === '' || $capacity <= 0) {
            return false;
        }

        $sql = "UPDATE restaurant_tables
                SET table_number = ?, capacity = ?
                WHERE id = ?";

        $statement = $this->db->prepare($sql);

        try {
            return $statement->execute([
                $tableNumber,
                $capacity,
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    
    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM restaurant_tables";

        $statement = $this->db->query($sql);

        return $statement->fetchColumn();
    }

    public function countActive()
    {
        $sql = "SELECT COUNT(*) FROM restaurant_tables
                WHERE is_active = 1";

        $statement = $this->db->query($sql);

        return $statement->fetchColumn();
    }


}
