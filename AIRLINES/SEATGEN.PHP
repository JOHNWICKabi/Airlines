
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('seats.jpg'); /* Replace with your background image URL */
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .booked {
            background-color: #ff8080; /* Red for booked seats */
        }

        .selected {
            background-color: #32bf5a; /* Blue for selected seats */
        }

        .book-button {
            padding: 10px;
            background-color: #db1c0b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .book-button:hover {
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

$tripId = $_GET['trip_id'];
$class = $_GET['class'];
$numberOfPassengers = $_GET['number_of_passengers'];

// Call procedure to get total seats
$seatCount = 0;
$query = "BEGIN GetSeatCount(:tripId, :class, :seatCount); END;";
$procedure = oci_parse($connection, $query);
oci_bind_by_name($procedure, ':tripId', $tripId);
oci_bind_by_name($procedure, ':class', $class);
oci_bind_by_name($procedure, ':seatCount', $seatCount);
oci_execute($procedure);
oci_free_statement($procedure);

// ...

// Call procedure to get booked seats
$bookedSeats = [];
$query = "BEGIN GetBookedSeats(:tripId, :class, :bookedSeats); END;";
$procedure = oci_parse($connection, $query);

// Bind parameters
oci_bind_by_name($procedure, ':tripId', $tripId);
oci_bind_by_name($procedure, ':class', $class);

// Bind a new cursor for the output
$cursor = oci_new_cursor($connection);
oci_bind_by_name($procedure, ':bookedSeats', $cursor, -1, OCI_B_CURSOR);

// Execute the procedure
oci_execute($procedure);

// Fetch the result set from the cursor
oci_execute($cursor);

// Display booked seats
echo "Booked Seats: ";
while ($row = oci_fetch_assoc($cursor)) {
    echo $row['SEAT_NO'] . ", ";
}

// Free resources
oci_free_statement($procedure);
oci_free_statement($cursor);

echo "<br>";  // Add a line break for better presentation

// Display seat selection
echo "<h2>Select your seats for Trip ID $tripId - $class class</h2>";

echo "<form method='post' action='final_booking.php'>";
echo "<input type='hidden' name='trip_id' value='$tripId'>";
echo "<input type='hidden' name='class' value='$class'>";
echo "<input type='hidden' name='number_of_passengers' value='$numberOfPassengers'>";
echo "<input type='hidden' name='selected_seats' id='selected_seats_input' value='[]'>";

for ($i = 1; $i <= $seatCount; $i++) {
    $seatStatus = in_array((string)$i, $bookedSeats) ? 'booked' : 'available';
    echo "<div class='seat $seatStatus' data-seat='$i'>$i</div>";
}

echo "<br><br>";
echo "<button type='submit' class='book-button'>Book Now</button>";
echo "</form>";

oci_close($connection);
?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedSeats = [];
    var maxPassengers = <?php echo $numberOfPassengers; ?>; // Get the maximum number of passengers

    document.querySelectorAll('.seat').forEach(function(seat) {
        seat.addEventListener('click', function() {
            if (selectedSeats.length < maxPassengers) {
                if (selectedSeats.includes(seat.dataset.seat)) {
                    selectedSeats = selectedSeats.filter(function(s) {
                        return s !== seat.dataset.seat;
                    });
                } else {
                    selectedSeats.push(seat.dataset.seat);
                }

                updateSeatStyles();
                updateSelectedSeatsInput();
            } else {
                alert('You cannot select more seats than the number of passengers.');
            }
        });
    });

    function updateSeatStyles() {
        document.querySelectorAll('.seat').forEach(function(seat) {
            if (selectedSeats.includes(seat.dataset.seat)) {
                seat.classList.add('selected');
            } else {
                seat.classList.remove('selected');
            }
        });
    }

    function updateSelectedSeatsInput() {
        document.getElementById('selected_seats_input').value = JSON.stringify(selectedSeats);
    }
});
</script>

</body>
</html>
