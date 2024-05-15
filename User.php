<?php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createUser($username, $active) {
        $sql = "INSERT INTO Users (username, active) VALUES ('$username', '$active')";
        $this->conn->query($sql);
    }
}
