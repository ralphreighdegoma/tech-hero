<?php

class Migrate {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // drop tables
    public function dropTables() {
        $sql_users = "DROP TABLE IF EXISTS Users";
        $sql_histories = "DROP TABLE IF EXISTS Histories";

        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");

        if ($this->conn->query($sql_users) === TRUE) {
            echo "Table Users dropped successfully\n";
        } else {
            echo "Error dropping table Users: " . $this->conn->error;
        }

        if ($this->conn->query($sql_histories) === TRUE) {
            echo "Table Histories dropped successfully\n";
        } else {
            echo "Error dropping table Histories: " . $this->conn->error;
        }

        $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");

    }

    public function createUsersTable() {
        $sql_users = "
        CREATE TABLE IF NOT EXISTS Users (
            user_id INT(10) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(200),
            active TINYINT(1)
        )";

        if ($this->conn->query($sql_users) === TRUE) {
            echo "Table Users created successfully\n";
        } else {
            echo "Error creating table Users: " . $this->conn->error;
        }
    }

    public function createHistoriesTable() {
        $sql_histories = "
        CREATE TABLE IF NOT EXISTS Histories (
            history_id INT(10) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(10),
            amount DOUBLE,
            country VARCHAR(200),
            active TINYINT(1),
            datetime DATETIME,
            FOREIGN KEY (user_id) REFERENCES Users(user_id)
        )";

        if ($this->conn->query($sql_histories) === TRUE) {
            echo "Table Histories created successfully\n";
        } else {
            echo "Error creating table Histories: " . $this->conn->error;
        }
    }
}

