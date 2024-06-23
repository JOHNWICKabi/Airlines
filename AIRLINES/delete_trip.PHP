<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Trip</title>
    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB012.jpg'); /* Replace 'your-background-image-url.jpg' with the actual URL or path to your background image */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            text-align: center;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Background color with opacity */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        form {
            margin-top: 20px;
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
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
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

        // Handle trip deletion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tripId = $_POST["trip_id"];

            // Call the stored procedure to delete the trip
            $deleteProcedure = "BEGIN DELETE_TRIP(:tripId); END;";
            $deleteStatement = oci_parse($connection, $deleteProcedure);
            oci_bind_by_name($deleteStatement, ':tripId', $tripId);
            oci_execute($deleteStatement);

            // Check if any rows were affected
            $rowsAffected = oci_num_rows($deleteStatement);

            if ($rowsAffected > 0) {
                echo 'Trip deleted successfully.';
            } else {
                echo 'Trip with given ID does not exist.';
            }

            oci_free_statement($deleteStatement);
        }

        oci_close($connection);
        ?>

        <!-- Add your HTML form here -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="trip_id">Enter Trip ID to Delete:</label>
            <input type="text" id="trip_id" name="trip_id" required>

            <button type="submit">Delete Trip</button>
        </form>

    </div>

</body>

</html>
