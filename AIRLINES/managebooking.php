<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('MANSEAT.jpg'); /* Replace 'your-background-image.jpg' with the actual URL or path to your background image */
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

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
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
            $bId = $_POST["b_id"];
            $tripId = $_POST["trip_id"];

            
            $findBookingQuery = "SELECT * FROM BOOKINGS WHERE B_ID = '$bId'";
            $findBookingResult = oci_parse($connection, $findBookingQuery);

            if (oci_execute($findBookingResult) && $bookingRow = oci_fetch_assoc($findBookingResult)) {
                
                $cId = $bookingRow['C_ID'];
                $updateBookingQuery = "UPDATE BOOKINGS SET STATUS = 'REFUND' WHERE B_ID = '$bId'";
                $updateBookingStatement = oci_parse($connection, $updateBookingQuery);

                if (oci_execute($updateBookingStatement)) {
                    
                    $deleteBookedTripQuery = "DELETE FROM BOOKED_TRIP WHERE C_ID = '$cId' AND TRIP_ID = '$tripId'";
                    $deleteBookedTripStatement = oci_parse($connection, $deleteBookedTripQuery);

                    if (oci_execute($deleteBookedTripStatement)) {
                        echo "Booking canceled successfully. Refund initiated.";
                    } else {
                        echo "Error canceling booking.";
                    }
                } else {
                    echo "Error updating booking status.";
                }
            } else {
                echo "Booking not found for the specified PNR Number and Trip ID.";
            }
        }

        oci_close($connection);
        ?>

        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="b_id">PNR Number (B_ID):</label>
            <input type="text" id="b_id" name="b_id" required>

            <label for="trip_id">Trip ID:</label>
            <input type="text" id="trip_id" name="trip_id" required>

            <button type="submit">Cancel Booking</button>
        </form>

    </div>

</body>

</html>
