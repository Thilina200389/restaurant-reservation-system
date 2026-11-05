<?php
ini_set('display_errors', '0');
ini_set('log_errors', '1');

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../app/Core/App.php';

$app = new App();
$app->run();
