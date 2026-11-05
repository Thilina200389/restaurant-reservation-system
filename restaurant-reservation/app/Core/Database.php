<?php

require_once __DIR__ . '/../../config/config.php';

class Database
{
    private $connection;

    public function connect()
    {
        if ($this->connection) {
            return $this->connection;
        }

        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->connection;

        } catch (PDOException $e) {
            die("Database connection failed.");
        }
    }
}
