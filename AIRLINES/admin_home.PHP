<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('admin.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff; /* Set text color to white for better contrast */
        }

        .container {
            text-align: center;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Add a semi-transparent black background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3); /* Add a subtle white shadow effect */
        }

        h2 {
            color: #fff; /* Set heading color to white */
        }

        .button {
            padding: 10px;
            margin: 10px;
            background-color: #db1c0b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">

    <?php
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php"); // Redirect to login page if not logged in
        exit();
    }
    ?>

    <h2>AB01 Airlines!</h2>

    <button class="button" onclick="location.href='VIEWTRIPS.php'">View Trips</button>
    <button class="button" onclick="location.href='add_trip.php'">Add Trip</button>
    <button class="button" onclick="location.href='ManageTrip.php'">ManageTrip</button>
    <button class="button" onclick="location.href='view_bookings.php'">View Bookings</button>
    <button class="button" onclick="location.href='permit.php'">Permit</button>
    <button class="button" onclick="location.href='delete_trip.php'">Delete Trip</button>
    <button class="button" onclick="location.href='AddAdmin.php'">Add Admin</button>
    <button class="button" onclick="location.href='AdminLogs.php'">Admin Logs</button>
    <button class="button" onclick="location.href='flight.php'">Flights</button>
    <button class="button" onclick="logout()">Logout</button>

<script>
    function logout() {
        window.location.href = 'admin_logout.php';
    }
</script>

</div>

</body>
</html>
