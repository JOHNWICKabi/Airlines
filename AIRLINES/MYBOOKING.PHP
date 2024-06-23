<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['C_ID'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Oracle database connection
$config = include('config.php');

$host = $config['host'];
$port = $config['port'];
$service_name = $config['service_name'];
$oracleUsername = $config['username'];
$oraclePassword = $config['password'];

$connection = oci_connect(
    $oracleUsername,
    $oraclePassword,
    "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = $service_name)))"
);

if (!$connection) {
    $error = oci_error();
    die('Connection failed: ' . $error['message']);
}

// Retrieve C_ID from session
$customerId = $_SESSION['C_ID'];

// Prepare the call to the procedure
$procedureCall = "BEGIN GET_BOOKINGS_BY_CUSTOMER(:customerId, :resultCursor); END;";
$procedure = oci_parse($connection, $procedureCall);

// Bind the output cursor
$resultCursor = oci_new_cursor($connection);
oci_bind_by_name($procedure, ':customerId', $customerId, -1, SQLT_INT);
oci_bind_by_name($procedure, ':resultCursor', $resultCursor, -1, OCI_B_CURSOR);

// Execute the procedure
if (oci_execute($procedure)) {
    // Execute the cursor
    oci_execute($resultCursor);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Bookings</title>
        <style>
            body {
            font-family: Arial, sans-serif;
            background-image: url('AB012.jpg'); /* Replace 'your-background-image.jpg' with the actual image file path */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

            header {
                background-color: #db1c0b;
                color: #ffffff;
                padding: 10px;
                text-align: center;
                margin-bottom: 20px;
            }

            .card-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 300px;
            }

            .card {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                padding: 20px;
                margin: 10px;
                max-width: 400px; /* Adjusted max-width */
                width: 100%;
            }

            h2 {
                color: #db1c0b;
            }
        </style>
    </head>

    <body>

        <header>
            <h1>AB01 Booking</h1>
            <a href="logout.php" class="logout-button">Logout</a>
        </header>

        <div class="card-container">
            <?php
            // Fetch and display the booking information
            while ($row = oci_fetch_assoc($resultCursor)) {
                echo '<div class="card">';
                echo '<h2>Trip ID: ' . $row['TRIP_ID'] . '</h2>';
                echo '<p>Booking ID: ' . $row['B_ID'] . '</p>';
                echo '<p>Number of Tickets: ' . $row['NO_OF_TICKETS'] . '</p>';
                echo '<p>Booking Date: ' . $row['B_DATE'] . '</p>';
                echo '<p>Status: ' . $row['STATUS'] . '</p>';
                echo '<p>Check-in: ' . $row['CHECKIN'] . '</p>';
                echo '<p>Class: ' . $row['CLASS'] . '</p>';
                echo '<p>Total Payment: $' . $row['TOTAL_PAYMENT'] . '</p>';
                echo '</div>';
            }

            // Free the statement and cursor
            oci_free_statement($procedure);
            oci_free_statement($resultCursor);
        } else {
            echo "Error executing the procedure.";
        }

        oci_close($connection);
        ?>

        </div>

    </body>

    </html>
