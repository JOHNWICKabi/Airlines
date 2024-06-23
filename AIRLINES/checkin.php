<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in</title>
    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB014.jpg'); /* Replace 'your-background-image.jpg' with the actual URL or path to your background image */
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
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
            background-color: #b01709;
        }
    </style>
</head>
<body>

<div class="card">

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

    // Handle check-in
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bId = $_POST["b_id"];
        $lastName = $_POST["last_name"];

        // Validate customer and retrieve booking details
        $validateQuery = "SELECT B.*, C.L_NAME 
                          FROM BOOKINGS B 
                          JOIN CUSTOMER C ON B.C_ID = C.C_ID 
                          WHERE B.B_ID = :bId AND C.L_NAME = :lastName";
        $validateStatement = oci_parse($connection, $validateQuery);
        oci_bind_by_name($validateStatement, ':bId', $bId);
        oci_bind_by_name($validateStatement, ':lastName', $lastName);
        oci_execute($validateStatement);

        if ($row = oci_fetch_assoc($validateStatement)) {
            // Update check-in status to 'YES'
            $updateQuery = "UPDATE BOOKINGS SET CHECKIN = 'YES' WHERE B_ID = :bId";
            $updateStatement = oci_parse($connection, $updateQuery);
            oci_bind_by_name($updateStatement, ':bId', $bId);

            if (oci_execute($updateStatement)) {
                echo '<p>Check-in successful for Booking ID: ' . $bId . '</p>';
            } else {
                echo '<p>Error updating check-in status.</p>';
            }
        } else {
            echo '<p>Invalid Booking ID or Last Name. Please try again.</p>';
        }

        oci_free_statement($validateStatement);
        oci_free_statement($updateStatement);
    }
    oci_close($connection);
    ?>

    <!-- Check-in form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="b_id">Booking ID (PNR Number):</label>
        <input type="text" id="b_id" name="b_id" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <button type="submit">Check-in</button>
    </form>

</div>

</body>
</html>
