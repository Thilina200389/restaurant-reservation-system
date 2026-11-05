<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/RestaurantTable.php';

class TableController extends Controller
{
    public function index()
    {
        $tableModel = new RestaurantTable();

        $tables = $tableModel->getAll();

        $this->view('tables/index', [
            'tables' => $tables
        ]);
    }

    public function create()
    {
        $this->view('tables/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=tables');
            exit;
        }

        $tableNumber = $_POST['table_number'] ?? '';
        $capacity = (int) ($_POST['capacity'] ?? 0);

        $tableModel = new RestaurantTable();

        if ($tableModel->add($tableNumber, $capacity)) {
            header('Location: index.php?url=tables');
            exit;
        }

        $this->view('tables/create', [
            'error' => 'Could not add table. Check the details or table number.'
        ]);
    }

    
public function toggleStatus()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?url=tables');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);

    $tableModel = new RestaurantTable();
    $tableModel->toggleStatus($id);

    header('Location: index.php?url=tables');
    exit;
}


    
public function edit()
{
    $id = (int) ($_GET['id'] ?? 0);

    $tableModel = new RestaurantTable();
    $table = $tableModel->getById($id);

    if (!$table) {
        http_response_code(404);
        echo "Table not found";
        return;
    }

    $this->view('tables/edit', [
        'table' => $table
    ]);
}

public function update()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?url=tables');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);
    $tableNumber = $_POST['table_number'] ?? '';
    $capacity = (int) ($_POST['capacity'] ?? 0);

    $tableModel = new RestaurantTable();

    if (!$tableModel->getById($id)) {
        http_response_code(404);
        echo "Table not found";
        return;
    }

    if ($tableModel->update($id, $tableNumber, $capacity)) {
        header('Location: index.php?url=tables');
        exit;
    }

    $this->view('tables/edit', [
        'table' => [
            'id' => $id,
            'table_number' => $tableNumber,
            'capacity' => $capacity
        ],
        'error' => 'Unable to update table. Please check the details.'
    ]);
}

}
