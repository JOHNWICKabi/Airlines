<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('SIGNIN3.jpg');
            background-size: cover;
            background-position: center;     
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            position: relative;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #f59e2c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #050505;
        }

        .result {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .home-icon {
            position: fixed;
            top: 10px;
            left: 10px;
            font-size: 24px;
            color: #ff8c00; /* Orange color */
            text-decoration: none;
            border: 2px solid #000;
            border-radius: 50%;
            padding: 5px;
            background-color: #000;
            transition: transform 0.2s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .home-icon:hover {
            transform: scale(1.2);
            background-color: #ff8c00; /* Orange color on hover */
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">

    <?php
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $flightId = $_POST["flight_id"];
        $departureDate = $_POST["departure_date"];

        // Modified SQL query directly
        $sql = "SELECT * FROM TRIP WHERE FLIGHT_ID = :flightId AND TRUNC(DEPARTURE) = TO_DATE(:departureDate, 'YYYY-MM-DD')";
        $statement = oci_parse($connection, $sql);

        oci_bind_by_name($statement, ':flightId', $flightId);
        oci_bind_by_name($statement, ':departureDate', $departureDate);

        oci_execute($statement);

        // Fetch result from the SQL query
        echo '<div class="result">';
        while ($row = oci_fetch_assoc($statement)) {
            echo 'Trip ID: ' . $row['TRIP_ID'] . ', Flight ID: ' . $row['FLIGHT_ID'] . ', Departure: ' . $row['DEPARTURE'] . ', Depart Time: ' . $row['DEPART_TIME'] . ', Arrival Time: ' . $row['ARRIVAL_TIME'] . ', Duration: ' . $row['DURATION_'] . ', Stops: ' . $row['STOPS'] . '<br>';
        }
        echo '</div>';

        oci_free_statement($statement);
    }

    oci_close($connection);
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="flight_id">Flight ID:</label>
        <input type="text" id="flight_id" name="flight_id" required>

        <label for="departure_date">Departure Date:</label>
        <input type="date" id="departure_date" name="departure_date" required>

        <button type="submit">Check Flight Status</button>
    </form>

    <a href="home.php" class="home-icon">&#8962;</a>

</div>

</body>
</html>
