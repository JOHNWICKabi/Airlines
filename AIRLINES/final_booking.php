<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #db1c0b;
        }

        button {
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #b01709;
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

        $connection = oci_connect(
            $oracleUsername,
            $oraclePassword,
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = $service_name)))"
        );

        if (!$connection) {
            $error = oci_error();
            die('Connection failed: ' . $error['message']);
        }

        $tripId = $_POST['trip_id'];
        $class = $_POST['class'];
        $numberOfPassengers = $_POST['number_of_passengers'];
        $selectedSeats = json_decode($_POST['selected_seats']);

        // Call procedure to get seat prices
        $seatPricesCursor = oci_new_cursor($connection);
        $queryPrices = "BEGIN GetSeatPrices(:tripId, :class, :seatPrices); END;";
        $procedurePrices = oci_parse($connection, $queryPrices);
        oci_bind_by_name($procedurePrices, ':tripId', $tripId);
        oci_bind_by_name($procedurePrices, ':class', $class);
        oci_bind_by_name($procedurePrices, ':seatPrices', $seatPricesCursor, -1, OCI_B_CURSOR);
        oci_execute($procedurePrices);
        oci_execute($seatPricesCursor);
        $prices = oci_fetch_assoc($seatPricesCursor);
        oci_free_statement($procedurePrices);

        // Calculate total payment
        $totalPayment = 0;
        foreach ($selectedSeats as $seat) {
            $totalPayment += $prices['PRICE'];
        }

        // Insert booked seats into BOOKED_TRIP table
        $customerId = $_SESSION['C_ID'];
        $queryInsert = "INSERT INTO BOOKED_TRIP (C_ID, TRIP_ID, SEAT_NO, BOOKED_CLASS) VALUES (:customerId, :tripId, :seatNo, :class)";
        $statementInsert = oci_parse($connection, $queryInsert);
        oci_bind_by_name($statementInsert, ':customerId', $customerId);
        oci_bind_by_name($statementInsert, ':tripId', $tripId);
        oci_bind_by_name($statementInsert, ':class', $class);

        foreach ($selectedSeats as $seat) {
            oci_bind_by_name($statementInsert, ':seatNo', $seat);
            oci_execute($statementInsert);
        }

        oci_free_statement($statementInsert);

        // Generate a unique booking ID
        $querySeq = "SELECT TO_CHAR(bookings_seq.NEXTVAL, 'FM000000') AS NEXTVAL FROM DUAL";
        $statementSeq = oci_parse($connection, $querySeq);
        oci_execute($statementSeq);
        $rowSeq = oci_fetch_assoc($statementSeq);
        $bookingId = $rowSeq['NEXTVAL'];
        $status = 'BOOKED';
        $checkin = 'NO';

        // Insert into BOOKINGS table
        $queryBookings = "INSERT INTO BOOKINGS (B_ID, C_ID, TRIP_ID, NO_OF_TICKETS, B_DATE, STATUS, CHECKIN, CLASS, TOTAL_PAYMENT) VALUES (:bookingId, :customerId, :tripId, :numberOfTickets, SYSDATE, :status, :checkin, :class, :totalPayment)";
        $statementBookings = oci_parse($connection, $queryBookings);
        oci_bind_by_name($statementBookings, ':bookingId', $bookingId);
        oci_bind_by_name($statementBookings, ':customerId', $customerId);
        oci_bind_by_name($statementBookings, ':tripId', $tripId);
        oci_bind_by_name($statementBookings, ':numberOfTickets', $numberOfPassengers);
        oci_bind_by_name($statementBookings, ':status', $status);
        oci_bind_by_name($statementBookings, ':checkin', $checkin);
        oci_bind_by_name($statementBookings, ':class', $class);
        oci_bind_by_name($statementBookings, ':totalPayment', $totalPayment);

        oci_execute($statementBookings);
        oci_free_statement($statementBookings);

        oci_close($connection);

        echo "<h2>Seats booked successfully! Total Payment: $" . $totalPayment . "</h2>";
        ?>
        
        <!-- Add a button to redirect to home.php -->
        <button onclick="window.location.href='home.php'">Go to Home</button>

    </div>

</body>

</html>
