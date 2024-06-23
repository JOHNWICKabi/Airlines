<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB012.jpg'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;     
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow-y: hidden; /* Disable vertical scrollbar */
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin: 10px 0;
        }

        select, input {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
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

// Retrieve forwarded TRIP_ID from the URL
$tripId = $_GET['trip_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $class = $_POST["class"];
    $number_of_passengers = $_POST["number_of_passengers"];

    // Forward to seatgen.php with collected data
    header("Location: seatgen.php?trip_id=$tripId&class=$class&number_of_passengers=$number_of_passengers");
    exit();
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?trip_id=$tripId"; ?>">
    <label for="class">Ticket Class:</label>
    <select id="class" name="class" required>
        <option value="Economy">Economy</option>
        <option value="Business">Business</option>
        <option value="First Class">First Class</option>
    </select>

    <label for="number_of_passengers">Number of Passengers:</label>
    <input type="number" id="number_of_passengers" name="number_of_passengers" min="1" max="9" required>

    <button type="submit">Proceed to Seat Selection</button>
</form>

</div>

</body>
</html>
