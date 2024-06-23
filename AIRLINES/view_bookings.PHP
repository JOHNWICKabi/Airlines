<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
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

    // Fetch booked trips from the database
    $query = "SELECT * FROM BOOKED_TRIP group by c_id,trip_id,seat_no,booked_class ORDER BY TRIP_ID,booked_class,seat_no ASC";
    $result = oci_parse($connection, $query);
    oci_execute($result);

    // Display booked trips in a table
    echo '<table>';
    echo '<tr><th>Customer ID</th><th>Trip ID</th><th>Seat No</th><th>Booked Class</th></tr>';
    while ($row = oci_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['C_ID'] . '</td>';
        echo '<td>' . $row['TRIP_ID'] . '</td>';
        echo '<td>' . $row['SEAT_NO'] . '</td>';
        echo '<td>' . $row['BOOKED_CLASS'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    oci_close($connection);
    ?>

</div>

</body>
</html>
