<?php

class App
{
    public function run()
    {
        $url = $_GET['url'] ?? 'dashboard';

        $routes = [
            'login'          => ['AuthController', 'index'],
            'login/submit'   => ['AuthController', 'login'],
            'logout'         => ['AuthController', 'logout'],

            'dashboard'      => ['DashboardController', 'index'],

            'tables'         => ['TableController', 'index'],
            'tables/create'  => ['TableController', 'create'],
            'tables/store'   => ['TableController', 'store'],
            'tables/edit'    => ['TableController', 'edit'],
            'tables/update'  => ['TableController', 'update'],
            'tables/toggle'  => ['TableController', 'toggleStatus'],

            'reservations'   => ['ReservationController', 'index'],
            'reservations/create' => ['ReservationController', 'create'],
            'reservations/store'  => ['ReservationController', 'store'],
            'reservations/edit'   => ['ReservationController', 'edit'],
            'reservations/update' => ['ReservationController', 'update'],
            'reservations/cancel' => ['ReservationController', 'cancel'],
        ];

        if (!isset($routes[$url])) {
            http_response_code(404);
            echo "Page not found";
            return;
        }

        // Only login routes are public
        $publicRoutes = ['login', 'login/submit'];

        if (!in_array($url, $publicRoutes) &&
            !isset($_SESSION['user_id'])) {

            header('Location: index.php?url=login');
            exit;
        }

        // Every state-changing request must come from one of our forms.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sent = $_POST['csrf_token'] ?? '';
            if (!is_string($sent) || !hash_equals($_SESSION['csrf_token'], $sent)) {
                http_response_code(403);
                echo 'Invalid form token. Please go back, refresh the page and try again.';
                return;
            }
        }

        [$controllerName, $method] = $routes[$url];

        require_once __DIR__ . '/../Controllers/' . $controllerName . '.php';

        $controller = new $controllerName();
        $controller->$method();
    }
}
