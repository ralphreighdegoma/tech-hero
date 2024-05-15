<?php
class History {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createHistory($user_id, $amount, $country, $active, $datetime) {
        $sql = "INSERT INTO Histories (user_id, amount, country, active, datetime) VALUES ('$user_id', '$amount', '$country', '$active', '$datetime')";
        $this->conn->query($sql);
    }
}
