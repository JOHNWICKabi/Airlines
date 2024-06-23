<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('trip1.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;     
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Change text color to make it readable on the background image */
        }

        .container {
            text-align: center;
            margin-top: 300px; /* Adjusted margin to keep the top within the visible area */
            background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow effect */
            max-width: 600px; /* Set a maximum width for better readability on larger screens */
            width: 90%; /* Use a percentage for responsiveness */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        label {
            margin-bottom: 10px;
            color: #333; /* Set label text color to a contrasting color */
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            width: 100%;
        }
        
        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
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

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $flightId = $_POST["flight_id"];
        $from = $_POST["from"];
        $to = $_POST["to"];
        $type = $_POST["type"];
        $departure = $_POST["departure"];
        $departTime = $_POST["depart_time"];
        $arrivalTime = $_POST["arrival_time"];
        $duration = $_POST["duration"];
        $stops = $_POST["stops"];
        $ePrice = $_POST["e_price"];
        $bPrice = $_POST["b_price"];
        $fPrice = $_POST["f_price"];

        $procedureCall = "BEGIN AddTrip(:flightId, :from, :to, :type, TO_DATE(:departure, 'YYYY-MM-DD'), :departTime, :arrivalTime, :duration, :stops, :ePrice, :bPrice, :fPrice); END;";
        $procedure = oci_parse($connection, $procedureCall);

        oci_bind_by_name($procedure, ':flightId', $flightId);
        oci_bind_by_name($procedure, ':from', $from);
        oci_bind_by_name($procedure, ':to', $to);
        oci_bind_by_name($procedure, ':type', $type);
        oci_bind_by_name($procedure, ':departure', $departure);
        oci_bind_by_name($procedure, ':departTime', $departTime);
        oci_bind_by_name($procedure, ':arrivalTime', $arrivalTime);
        oci_bind_by_name($procedure, ':duration', $duration);
        oci_bind_by_name($procedure, ':stops', $stops);
        oci_bind_by_name($procedure, ':ePrice', $ePrice);
        oci_bind_by_name($procedure, ':bPrice', $bPrice);
        oci_bind_by_name($procedure, ':fPrice', $fPrice);
        
        oci_execute($procedure);
        oci_commit($connection);


        echo "Trip added successfully!";
    }
    oci_close($connection);
    ?>

    <!-- Add your HTML form here -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="flight_id">Flight ID:</label>
        <input type="text" id="flight_id" name="flight_id" required>

        <label for="from">From:</label>
        <input type="text" id="from" name="from" required>

        <label for="to">To:</label>
        <input type="text" id="to" name="to" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required>

        <label for="departure">Departure Date:</label>
        <input type="date" id="departure" name="departure" required>

        <label for="depart_time">Depart Time:</label>
        <input type="text" id="depart_time" name="depart_time" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="text" id="arrival_time" name="arrival_time" required>

        <label for="duration">Duration:</label>
        <input type="number" id="duration" name="duration" required>

        <label for="stops">Stops:</label>
        <input type="number" id="stops" name="stops" required>

        <label for="e_price">Economy Price:</label>
        <input type="number" id="e_price" name="e_price" required>

        <label for="b_price">Business Price:</label>
        <input type="number" id="b_price" name="b_price" required>

        <label for="f_price">First Class Price:</label>
        <input type="number" id="f_price" name="f_price" required>

        <button type="submit">Add Trip</button>
    </form>

</div>

</body>
</html>
