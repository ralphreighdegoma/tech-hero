<?php
require '../Auth.php';
require '../Connection.php';
require '../Country.php';


$selectedCountry = isset($_GET['country']) ? $_GET['country'] : null;
$usernameFilter = isset($_GET['username']) ? $_GET['username'] : null;
$fromDateFilter = isset($_GET['fromDate']) ? $_GET['fromDate'] : date('Y-m-01');
$toDateFilter = isset($_GET['toDate']) ? $_GET['toDate'] : date('Y-m-t');

$countryInstance = new Country($database->getConnection());
$users = $countryInstance->getUsersByCountry($selectedCountry, $usernameFilter, $fromDateFilter, $toDateFilter);

echo "<h2>Users in $selectedCountry</h2>";
?>

<a href="countries.php">Back</a>
<a href="logout.php">Logout</a>

<form action="" method="GET">
    <input type="hidden" name="country" value="<?php echo $selectedCountry; ?>">
    <label for="username">Filter by Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usernameFilter); ?>">

    <label for="fromDate">From:</label>
    <input type="date" id="fromDate" name="fromDate" value="<?php echo htmlspecialchars($fromDateFilter); ?>">

    <label for="toDate">To:</label>
    <input type="date" id="toDate" name="toDate" value="<?php echo htmlspecialchars($toDateFilter); ?>">

    <input type="submit" value="Apply Filter">
</form>


<?php
    echo "<table border='1'>";
    echo "<thead><tr><th>User ID</th><th>Username</th><th>Total User's Amount</th><th>Last History Date Time</th></tr></thead>";
    echo "<tbody>";
    foreach($users as $user) {
        echo "<tr>";
        echo "<td>".$user['user_id']."</td>";
        echo "<td>".$user['username']."</td>";
        echo "<td>".$user['total_user_amount']."</td>";
        echo "<td>".$user['last_history_date_time']."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

?>
