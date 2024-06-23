<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permits</title>
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
            margin-top: 20px;
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

        form {
            margin-top: 20px;
        }

        form label, form input {
            margin-bottom: 10px;
        }

        form button {
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #db1c0b;
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

    // Fetch permits from the database
    $query = "SELECT * FROM PERMIT";
    $result = oci_parse($connection, $query);
    oci_execute($result);

    // Display permits in a table
    echo '<table>';
    echo '<tr><th>Trip ID</th><th>Airport Authority</th><th>Departure Terminal</th><th>Arrival Terminal</th><th>Gate No</th></tr>';
    while ($row = oci_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['TRIP_ID'] . '</td>';
        echo '<td>' . $row['AIRPORT_AUTHORITY'] . '</td>';
        echo '<td>' . $row['DEPARTURE_TERMINAL'] . '</td>';
        echo '<td>' . $row['ARRIVAL_TERMINAL'] . '</td>';
        echo '<td>' . $row['GATE_NO'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    oci_close($connection);
    ?>

    <!-- Form to add new permits -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="trip_id">Trip ID:</label>
        <input type="number" id="trip_id" name="trip_id" required>

        <label for="authority">Airport Authority:</label>
        <input type="text" id="authority" name="authority" required>

        <label for="departure_terminal">Departure Terminal:</label>
        <input type="number" id="departure_terminal" name="departure_terminal" required>

        <label for="arrival_terminal">Arrival Terminal:</label>
        <input type="number" id="arrival_terminal" name="arrival_terminal" required>

        <label for="gate_no">Gate No:</label>
        <input type="number" id="gate_no" name="gate_no" required>

        <button type="submit">Add Permit</button>
    </form>

</div>

</body>
</html>

<?php
// Handle form submission to add new permit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tripId = $_POST["trip_id"];
    $authority = $_POST["authority"];
    $departureTerminal = $_POST["departure_terminal"];
    $arrivalTerminal = $_POST["arrival_terminal"];
    $gateNo = $_POST["gate_no"];

    // Insert new permit into the database
    $insertQuery = "INSERT INTO PERMIT (TRIP_ID, AIRPORT_AUTHORITY, DEPARTURE_TERMINAL, ARRIVAL_TERMINAL, GATE_NO) 
                    VALUES ('$tripId', '$authority', '$departureTerminal', '$arrivalTerminal', '$gateNo')";
    $insertStatement = oci_parse($connection, $insertQuery);
    if (oci_execute($insertStatement)) {
        echo '<script>alert("Permit added successfully.");</script>';
        // Refresh the page after adding a permit
        echo '<script>window.location.replace("permit.php");</script>';
    } else {
        echo '<script>alert("Error adding permit. Please try again.");</script>';
    }
    oci_free_statement($insertStatement);
}
?>
