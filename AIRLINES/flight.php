<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-image: url('AB012.jpg'); /* Add your background image URL here */
        background-size: cover;
        background-position: center;     
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    .container {
    text-align: center;
    margin-top: 50px;
    background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    max-width: 600px;
    width: 90%;
}


        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        label {
            margin-bottom: 10px;
            color: #050505; /* White text for contrast */
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            width: 100%;
        }
        
        button {
            padding: 10px;
            background-color: #990000; /* Dark red button */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #660000; /* Darker red on hover */
        }
    </style>
</head>
<body>

<div class="container">

    <?php
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
        $flightType = $_POST["flight_type"];
        $seats = $_POST["seats"];
        $flightWeight = $_POST["flight_weight"];
        $eSeats = $_POST["e_seats"];
        $bSeats = $_POST["b_seats"];
        $fSeats = $_POST["f_seats"];

        $procedureCall = "BEGIN AddFlight(:flightId, :flightType, :seats, :flightWeight, :eSeats, :bSeats, :fSeats); END;";
        $procedure = oci_parse($connection, $procedureCall);

        oci_bind_by_name($procedure, ':flightId', $flightId);
        oci_bind_by_name($procedure, ':flightType', $flightType);
        oci_bind_by_name($procedure, ':seats', $seats);
        oci_bind_by_name($procedure, ':flightWeight', $flightWeight);
        oci_bind_by_name($procedure, ':eSeats', $eSeats);
        oci_bind_by_name($procedure, ':bSeats', $bSeats);
        oci_bind_by_name($procedure, ':fSeats', $fSeats);

        oci_execute($procedure);
        oci_commit($connection);
        // Check for errors
        $error = oci_error($procedure);
        if ($error) {
            echo "Error: " . $error['message'];
        } else {
            echo "Flight added successfully!";
        }
    }
    oci_close($connection);
    ?>

    <!-- Add your HTML form here -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="flight_id">Flight ID:</label>
        <input type="text" id="flight_id" name="flight_id" required>

        <label for="flight_type">Flight Type:</label>
        <input type="text" id="flight_type" name="flight_type" required>

        <label for="seats">Total Seats:</label>
        <input type="number" id="seats" name="seats" required>

        <label for="flight_weight">Flight Weight:</label>
        <input type="number" id="flight_weight" name="flight_weight" required>

        <label for="e_seats">Economy Seats:</label>
        <input type="number" id="e_seats" name="e_seats" required>

        <label for="b_seats">Business Seats:</label>
        <input type="number" id="b_seats" name="b_seats" required>

        <label for="f_seats">First Class Seats:</label>
        <input type="number" id="f_seats" name="f_seats" required>

        <button type="submit">Add Flight</button>
    </form>

</div>

</body>
</html>
