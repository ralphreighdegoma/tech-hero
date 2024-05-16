
<?php

require '../Auth.php';
require '../Connection.php';
require '../Country.php';

$countryFilter = isset($_GET['country']) ? $_GET['country'] : null;
$fromDateFilter = isset($_GET['fromDate']) ? $_GET['fromDate'] : date('Y-m-01');
$toDateFilter = isset($_GET['toDate']) ? $_GET['toDate'] : date('Y-m-t');

$country = new Country($database->getConnection());
$countries = $country->getCountries($countryFilter, $fromDateFilter, $toDateFilter);
$countriesSrc = $country->getCountries(null, $fromDateFilter, $toDateFilter);

?>

<h2>Countries - Page 1</h2>
<a href="logout.php">Logout</a>

<form action="" method="GET">
    <label for="country">Filter by Country:</label>
    <select id="country" name="country">
        <option value="">All Countries</option>
        <?php foreach($countriesSrc as $country): ?>
            <option value="<?php echo htmlspecialchars($country['country']); ?>"><?php echo htmlspecialchars($country['country']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="fromDate">From:</label>
    <input type="date" id="fromDate" name="fromDate" value="<?php echo htmlspecialchars($fromDateFilter); ?>">

    <label for="toDate">To:</label>
    <input type="date" id="toDate" name="toDate" value="<?php echo htmlspecialchars($toDateFilter); ?>">

    <input type="submit" value="Apply Filter">
</form>


<table border="1">
    <thead>
        <tr>
            <th>Country</th>
            <th>Total Active User's Amount</th>
            <th>Last History Date Time</th>
            <th>No. Of Unique Users</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($countries as $country): ?>
            <tr>
                <td>
                    <a href="country-users.php?country=<?php echo urlencode($country['country']); ?>">
                        <?php echo $country['country']; ?>
                    </a>
                </td>
                <td style="text-align: right;"><?php echo number_format($country['total_active_users_amount']); ?></td>
                <td><?php echo $country['last_history_date_time']; ?></td>
                <td><?php echo $country['no_of_unique_users']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
