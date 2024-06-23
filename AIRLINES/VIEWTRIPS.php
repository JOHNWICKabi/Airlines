<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Trips</title>
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
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 200px;
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

    // Call the procedure to get trips
    $procedureCall = "BEGIN GetTrips(:cursor); END;";
    $procedure = oci_parse($connection, $procedureCall);
    $cursor = oci_new_cursor($connection);
    oci_bind_by_name($procedure, ':cursor', $cursor, -1, OCI_B_CURSOR);

    // Execute the procedure
    oci_execute($procedure);

    // Execute the cursor
    oci_execute($cursor);

    // Fetch the result set
    echo '<table>';
    echo '<tr><th>Trip ID</th><th>Flight ID</th><th>From</th><th>To</th><th>Type</th><th>Departure</th><th>Depart Time</th><th>Arrival Time</th><th>Duration</th><th>Stops</th></tr>';
    while ($row = oci_fetch_assoc($cursor)) {
        echo '<tr>';
        echo '<td>' . $row['TRIP_ID'] . '</td>';
        echo '<td>' . $row['FLIGHT_ID'] . '</td>';
        echo '<td>' . $row['FROM_'] . '</td>';
        echo '<td>' . $row['TO_'] . '</td>';
        echo '<td>' . $row['TYPE_'] . '</td>';
        echo '<td>' . $row['DEPARTURE'] . '</td>';
        echo '<td>' . $row['DEPART_TIME'] . '</td>';
        echo '<td>' . $row['ARRIVAL_TIME'] . '</td>';
        echo '<td>' . $row['DURATION_'] . '</td>';
        echo '<td>' . $row['STOPS'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    oci_free_statement($procedure);
    oci_free_statement($cursor);
    oci_close($connection);
    ?>

</div>

</body>
</html>
