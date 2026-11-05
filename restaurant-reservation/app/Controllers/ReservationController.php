<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Reservation.php';
require_once __DIR__ . '/../Models/RestaurantTable.php';

class ReservationController extends Controller
{
    
    public function index()
    {
        $reservationModel = new Reservation();

        $keyword = trim($_GET['search'] ?? '');

        if ($keyword !== '') {
            $reservations = $reservationModel->search($keyword);
        } else {
            $reservations = $reservationModel->getAll();
        }

        $this->view('reservations/index', [
            'reservations' => $reservations,
            'keyword' => $keyword
        ]);
    }

        
    public function create()
    {
        $tableModel = new RestaurantTable();

        $this->view('reservations/create', [
            'tables' => $tableModel->getAll()
        ]);
    }



    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=reservations');
            exit;
        }

        $data = [
            'customer_name' => $_POST['customer_name'] ?? '',
            'customer_phone' => $_POST['customer_phone'] ?? '',
            'table_id' => (int) ($_POST['table_id'] ?? 0),
            'user_id' => (int) $_SESSION['user_id'],
            'guest_count' => (int) ($_POST['guest_count'] ?? 0),
            'start_time' => str_replace('T', ' ', $_POST['start_time'] ?? ''),
            'end_time' => str_replace('T', ' ', $_POST['end_time'] ?? ''),
            'notes' => $_POST['notes'] ?? ''
        ];

        $reservationModel = new Reservation();

        try {
            $saved = $reservationModel->add($data);
        } catch (PDOException $e) {
            $saved = false;
        }

        if ($saved) {
            header('Location: index.php?url=reservations');
            exit;
        }

        $tableModel = new RestaurantTable();

        $this->view('reservations/create', [
            'tables' => $tableModel->getAll(),
            'error' => $reservationModel->getError() ?: 'Could not save reservation.',
            'old' => $data
        ]);
    }


    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $reservationModel = new Reservation();
        $reservation = $reservationModel->getById($id);

        if (!$reservation || $reservation['status'] === 'cancelled') {
            http_response_code(404);
            echo "Reservation not found or cancelled";
            return;
        }

        $tableModel = new RestaurantTable();

        $this->view('reservations/edit', [
            'reservation' => $reservation,
            'tables' => $tableModel->getAll()
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=reservations');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'customer_name' => $_POST['customer_name'] ?? '',
            'customer_phone' => $_POST['customer_phone'] ?? '',
            'table_id' => (int) ($_POST['table_id'] ?? 0),
            'guest_count' => (int) ($_POST['guest_count'] ?? 0),
            'start_time' => str_replace('T', ' ', $_POST['start_time'] ?? ''),
            'end_time' => str_replace('T', ' ', $_POST['end_time'] ?? ''),
            'notes' => $_POST['notes'] ?? ''
        ];

        $reservationModel = new Reservation();

        if ($reservationModel->update($id, $data)) {
            header('Location: index.php?url=reservations');
            exit;
        }

        $tableModel = new RestaurantTable();

        $this->view('reservations/edit', [
            'reservation' => array_merge($data, ['id' => $id]),
            'tables' => $tableModel->getAll(),
            'error' => $reservationModel->getError() ?: 'Unable to update reservation.'
        ]);
    }

    public function cancel()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=reservations');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        $reservationModel = new Reservation();
        $reservationModel->cancel($id);

        header('Location: index.php?url=reservations');
        exit;
    }

    
}
