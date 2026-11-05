<?php

require_once __DIR__ . '/../Core/Model.php';

class User extends Model
{
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$username]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
