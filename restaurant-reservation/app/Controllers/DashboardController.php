<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/RestaurantTable.php';
require_once __DIR__ . '/../Models/Reservation.php';

class DashboardController extends Controller
{
    public function index()
    {
        $tableModel = new RestaurantTable();
        $reservationModel = new Reservation();

        $this->view('dashboard/index', [
            'totalTables' => $tableModel->countAll(),
            'activeTables' => $tableModel->countActive(),
            'todayReservations' => $reservationModel->countToday()
        ]);
    }
}
