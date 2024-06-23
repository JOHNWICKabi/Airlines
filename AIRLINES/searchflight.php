<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Flights</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB011.jpg'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;     
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow-y: hidden;
        }

        .container {
            text-align: center;
            display: flex;
            flex-wrap: wrap; /* Allow cards to wrap to the next line */
            justify-content: center;
            max-height: 100vh; /* Set a maximum height for the container */
            overflow-y: auto; /* Enable vertical scrollbar for the container */
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            max-width: 300px; /* Set a maximum width for the cards */
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin: 10px 0;
            font-weight: bold;
            display: block;
        }

        input {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #0056b3;
        }

        .card-button {
            display: block;
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .card-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">

<?php
session_start();

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
    $from = strtoupper($_POST["from"]);
    $to = strtoupper($_POST["to"]);
    $departureDate = strtoupper($_POST["departure_date"]);

    $procedureCall = "BEGIN GetTripDetailsWithPrices(TO_DATE(:departureDate, 'DD-MON-YY'), :from, :to, :cursor); END;";
    $procedure = oci_parse($connection, $procedureCall);

    oci_bind_by_name($procedure, ':from', $from);
    oci_bind_by_name($procedure, ':to', $to);
    oci_bind_by_name($procedure, ':departureDate', $departureDate);
    $cursor = oci_new_cursor($connection);
    oci_bind_by_name($procedure, ':cursor', $cursor, -1, OCI_B_CURSOR);

    oci_execute($procedure);
    oci_execute($cursor);

    while ($row = oci_fetch_assoc($cursor)) {
        echo '<div class="card" style="max-width: 350px;">'; // Increased max-width
        echo '<div class="card-header">Flight Details</div>';
        echo '<div class="card-body">';
        echo '<p><strong>Trip ID:</strong> ' . $row['TRIP_ID'] . '</p>';
        echo '<p><strong>Flight ID:</strong> ' . $row['FLIGHT_ID'] . '</p>';
        echo '<p><strong>From:</strong> ' . $row['FROM_'] . '</p>';
        echo '<p><strong>To:</strong> ' . $row['TO_'] . '</p>';
        echo '<p><strong>Departure:</strong> ' . $row['DEPARTURE'] . '</p>';
        echo '<p><strong>Depart Time:</strong> ' . $row['DEPART_TIME'] . '</p>';
        echo '<p><strong>Arrival Time:</strong> ' . $row['ARRIVAL_TIME'] . '</p>';
        echo '<p><strong>Duration:</strong> ' . $row['DURATION_'] . '</p>';
        echo '<p><strong>Stops:</strong> ' . $row['STOPS'] . '</p>';
        echo '<p><strong>E Price:</strong> ' . $row['E_PRICE'] . '</p>';
        echo '<p><strong>B Price:</strong> ' . $row['B_PRICE'] . '</p>';
        echo '<p><strong>F Price:</strong> ' . $row['F_PRICE'] . '</p>';
        echo '<p><strong>E Available:</strong> ' . $row['E_AVAILABLE'] . '</p>';
        echo '<p><strong>B Available:</strong> ' . $row['B_AVAILABLE'] . '</p>';
        echo '<p><strong>F Available:</strong> ' . $row['F_AVAILABLE'] . '</p>';
        echo '<a class="card-button" href="booking.php?trip_id=' . $row['TRIP_ID'] . '">Book Now</a>';
        echo '</div>';
        echo '</div>';
    }
    
    oci_free_statement($procedure);
    oci_free_statement($cursor);
}

oci_close($connection);
?>

<div class="card form-container">
    <div class="card-header">Search Flights</div>
    <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="from">From:</label>
            <input type="text" id="from" name="from" required>

            <label for="to">To:</label>
            <input type="text" id="to" name="to" required>

            <label for="departure_date">Departure Date:</label>
            <input type="text" id="departure_date" name="departure_date" placeholder="e.g., 11-NOV-2023" required>

            <button type="submit">Search Flights</button>
        </form>
    </div>
</div>

</div>

</body>
</html>
