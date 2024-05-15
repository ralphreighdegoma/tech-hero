<?php
class Country {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUsersByCountry($selectedCountry, $usernameFilter, $fromDateFilter, $toDateFilter) {

        if ($selectedCountry != "") {
            $countryFilter = "AND h.country = '$selectedCountry'";
        }else {
            $countryFilter = "";
        }

        if ($fromDateFilter != "" && $toDateFilter != "") {
            $dateFiler = "AND h.datetime BETWEEN '$fromDateFilter' AND '$toDateFilter'";
        }else {
            $dateFiler = "";
        }
        if ($usernameFilter != "") {
            $usernameFilter = "AND u.username = '$usernameFilter'";
        }else {
            $usernameFilter = "";
        }

        $sql = "
                SELECT u.user_id AS `user_id`,
                u.username AS `username`,
                SUM(h.amount) AS `total_user_amount`,
                MAX(h.datetime) AS `last_history_date_time`
            FROM
                Users u
            INNER JOIN
                Histories h ON u.user_id = h.user_id
            WHERE
                u.active = 1 AND
                h.active = 1 
                $countryFilter
                $dateFiler
                $usernameFilter
            GROUP BY
                u.user_id, u.username;
            ";

        $result = $this->conn->query($sql);

        if (!$result) {
            echo "Query Error: " . $this->conn->error;
            return [];
        }

        if ($result->num_rows == 0) {
            echo "No data matched the criteria.";
            return [];
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();

        return $data;
    }

    public function getCountries($countryFilter, $fromDateFilter, $toDateFilter) {
        $dateTimeSql = "";
        if ($fromDateFilter == "" && $toDateFilter == "") {
            $fromDateFilter = date('Y-m-01');
            $toDateFilter = date('Y-m-t');
            $dateTimeSql = " AND h.datetime BETWEEN '$fromDateFilter' AND '$toDateFilter'";
        }else {
            $dateTimeSql = " AND h.datetime BETWEEN '$fromDateFilter' AND '$toDateFilter'";
        }

        if ($countryFilter == "") {
            $countryFilter = "";
        }else {
            $countryFilter = "AND h.country = '$countryFilter'";
        }
        
        $sql = "
            SELECT
                h.country AS country,
                SUM(h.amount) AS total_active_users_amount,
                MAX(h.datetime) AS last_history_date_time,
                COUNT(DISTINCT u.user_id) AS no_of_unique_users
            FROM
                Histories h
            INNER JOIN
                Users u ON h.user_id = u.user_id
            WHERE
                h.active = 1 AND
                u.active = 1
                $countryFilter 
                $dateTimeSql
            GROUP BY
                h.country";


        $result = $this->conn->query($sql);

        if (!$result) {
            echo "Query Error: " . $this->conn->error;
            return []; 
        }

        if ($result->num_rows == 0) {
            echo "No data matched the criteria.";
            return [];
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();

        return $data;
    }

}
