<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs</title>
    <!-- Add your styles here -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        overflow-x: auto; /* Added this line for horizontal scrolling */
    }

    .container {
        text-align: center;
        margin-top: 20px;
        overflow-x: auto; /* Added this line for horizontal scrolling */
    }

    table {
        width: 100%; /* Changed to 100% to make the table take full width */
        border-collapse: collapse;
        margin-top: 20px;
        overflow-x: auto; /* Added this line for horizontal scrolling */
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #db1c0b;
        color: #fff;
    }
</style>

</head>
<body>

<div class="container">

    <?php
    session_start();

    // Oracle database connection
    $config = include('config.php');

$host = $config['host'];
$port = $config['port'];
$service_name = $config['service_name'];
$oracleUsername = $config['username'];
$oraclePassword = $config['password'];

    $connection = oci_connect($oracleUsername, $oraclePassword, "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = $service_name)))");

    if (!$connection) {
        $error = oci_error();
        die('Connection failed: ' . $error['message']);
    }

    // Fetch admin logs with admin details from the database
    $query = "SELECT AL.*, A.FIRST_NAME, A.LAST_NAME FROM ADMINLOGS AL JOIN ADMIN A ON AL.ADMIN_ID = A.ADMIN_ID";
    $result = oci_parse($connection, $query);
    oci_execute($result);

    // Display admin logs with admin details in a table
    echo '<table>';
    echo '<tr><th>Log ID</th><th>Admin ID</th><th>First Name</th><th>Last Name</th><th>Log Time</th></tr>';
    while ($row = oci_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['LOG_ID'] . '</td>';
        echo '<td>' . $row['ADMIN_ID'] . '</td>';
        echo '<td>' . $row['FIRST_NAME'] . '</td>';
        echo '<td>' . $row['LAST_NAME'] . '</td>';
        echo '<td>' . $row['LOG_TIME'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    oci_close($connection);
    ?>

</div>

</body>
</html>
