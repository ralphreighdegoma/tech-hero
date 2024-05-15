<?php

require 'User.php';
require 'History.php';
require 'countries-source.php';
require 'Migrate.php';
require 'Connection.php';



$user = new Migrate($database->getConnection());
$user->dropTables();
$user->createUsersTable();
$user->createHistoriesTable();

for ($i = 1; $i <= 3000; $i++) {
    $username = "user" . $i;
    $active = ($i % 10 == 0) ? 0 : 1;
    $user = new User($database->getConnection());
    $user->createUser($username, $active);
}

for ($i = 1; $i <= 3000000; $i++) {
    $user_id = rand(1, 3000);
    $amount = mt_rand(10, 1000) / 10;
    $amount = floor($amount);

    $randomIndex = array_rand($countries);
    $country = $countries[$randomIndex];

    $active = (rand(1, 10) == 1) ? 0 : 1;
    $datetime = date('Y-m-d H:i:s', mt_rand(strtotime('2023-05-01'), strtotime('2024-06-30')));

    $history = new History($database->getConnection());
    $history->createHistory($user_id, $amount, $country, $active, $datetime);
}

$database->closeConnection();
