<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AB01 Airlines</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            width: 100%;
            background-color: #db1c0b; /* Red background */
            color: #ffffff; /* White text */
            padding: 10px 20px;
            box-sizing: border-box; /* Include padding in the element's total width and height */
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px; /* Max width for the header content */
            margin: 0 auto; /* Center align the header content */
        }

        .header-container h1 {
            margin: 0;
        }

        .nav-menu {
            display: flex;
            align-items: center;
        }

        .nav-menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #ffffff; /* White text */
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #ccc; /* Lighter color on hover */
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .auth-icons {
            display: flex;
            align-items: center;
        }

        .auth-icons a {
            font-size: 24px;
            color: #ffffff; /* White */
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .auth-icons a:hover {
            color: #ccc; /* Lighter color on hover */
        }

        .user-details-icon {
            font-size: 24px;
            color: #ffffff; /* White */
            transition: color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            border: 2px solid #ffffff; /* White border */
            border-radius: 50%; /* Make it a circle */
            padding: 5px; /* Add some padding for better appearance */
            background-color: #db1c0b; /* Red background */
            margin-right: 10px; /* Adjust margin as needed */
        }

        .user-details-icon:hover {
            color: #ccc; /* Lighter color on hover */
            transform: scale(1.2);
            border-color: #ccc; /* Lighter border on hover */
        }

        .logout-button {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px; /* Adjust margin as needed */
        }

        .logout-button:hover {
            background-color: #a31500;
        }

    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>AB01 Booking</h1>
            <div class="nav-menu">
                <a href="searchflight.php">BOOK</a>
                <div class="dropdown">
                    <a href="#">MANAGE</a>
                    <div class="dropdown-content">
                        <a href="mybooking.php">My Bookings</a>
                        <a href="managebooking.php">Manage Booking</a>
                        <a href="checkin.php">Check In</a>
                        <a href="flightstatus.php">Flight Status</a>
                    </div>
                </div>
            </div>
            <div class="auth-icons">
                <a href="login.php" class="icon">&#128100;</a> <!-- Login icon -->
                <a href="signup.php" class="icon">&#128100;</a> <!-- Signup icon -->
                <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="userdetails.php" class="user-details-icon">&#9992;</a>'; // User details icon
                    echo '<a href="logout.php" class="logout-button">Logout</a>';
                }
                ?>
            </div>
        </div>
    </header>
    <!-- Your other content goes here -->
</body>
</html>
