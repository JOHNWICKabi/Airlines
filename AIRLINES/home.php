<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Home</title><!-- Add your own stylesheet for customization -->
    <style>
    body {
            font-family: Arial, sans-serif;
            background-image: url('new1.jpg');
            background-size: cover;
            background-position: center;     
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        header {
            background-color: #db1c0b; /* Dark grayish-blue */
            color: #ffffff; /* White text */
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .branding h1 {
            margin: 0;
        }

        .branding p {
            margin: 0;
            color: #ff0000; /* Red text for "User not logged in" */
        }


        nav {
            background-color: #343a40; /* Dark grayish-blue */
            padding: 10px;
            text-align: center;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #ffffff; /* White text */
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .button-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    height: 50vh; /* Adjust the height as needed */
    padding: 20px;
}

.button {
    display: inline-flex; /* Use flexbox */
    flex-direction: column; /* Arrange items in a column */
    align-items: center; /* Center items horizontally */
    width: 150px;
    height: 150px;
    margin: 20px;
    text-decoration: none;
    color: #030303;
    border-radius: 10px;
    transition: background 0.3s ease, transform 0.2s ease;
    background-size: cover;
    position: relative; /* Add relative positioning */
    overflow: hidden; /* Hide overflowing background */
}



.button:hover {
    background-color: #db1c0b;
    transform: scale(1.05);
}


.icon {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    color: #007bff; /* Blue */
    transition: color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
    border: 2px solid #ffffff; /* White border */
    border-radius: 50%; /* Make it a circle */
    padding: 5px; /* Add some padding for better appearance */
    background-color: #ffffff; /* White background */
}

.icon:hover {
    color: #0056b3; /* Darker blue on hover */
    transform: scale(1.2);
    border-color: #0056b3; /* Darker blue border on hover */
}

        .search-button {
    background: url('SEARCH.jpg') center/cover no-repeat;
}
.mybooking-button{
    background: url('MYBK.jpg') center/cover no-repeat;
}
.manage-button {
    background: url('MANAGE.jpg') center/cover no-repeat;
}

.checkin-button {
    background: url('CHECKIN.jpg') center/cover no-repeat;
}

.status-button {
    background: url('STATUS.jpg') center/cover no-repeat;
}
.user-details-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            color: #db1c0b; /* Blue */
            transition: color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            border: 2px solid #db1c0b; /* White border */
            border-radius: 50%; /* Make it a circle */
            padding: 5px; /* Add some padding for better appearance */
            background-color: #ffffff; /* White background */
        }

        .user-details-icon:hover {
            color: #0056b3; /* Darker blue on hover */
            transform: scale(1.2);
            border-color: #0056b3; /* Darker blue border on hover */
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
        }

        .logout-button:hover {
            background-color: #a31500;
        }
        
    </style>
</head>
<body>

    <header>
        <h1>AB01 Booking</h1>
        <?php
    if (isset($_SESSION['user_id'])) {
        echo '<a href="userdetails.php" class="user-details-icon">&#9992;</a>'; // User details icon
        echo '<p>User ID: ' . $_SESSION['user_id'] . '</p>'; // Debug information
        echo '<a href="logout.php" class="logout-button">Logout</a>';
    } else {
        echo '<p>User not logged in</p>'; // Debug information
    }
    ?>
    </header>

    <a href="login.php" class="icon">&#128100;</a> <!-- Login icon -->
    <a href="signup.php" class="icon">&#128100;</a> <!-- Signup icon -->

<div class="button-container">
    <a href="searchflight.php" class="button search-button">   Search Flight</a>
    <a href="managebooking.php" class="button manage-button">   Manage Booking</a>
    <a href="checkin.php" class="button checkin-button">   Check In</a>
    <a href="flightstatus.php" class="button status-button">Flight Status</a>
    <a href="mybooking.php" class="button mybooking-button">My Booking</a>

</div>


    <section>
        <h2></h2>
        <p></p>
    </section>

    <footer>
        
    </footer>

</body>
</html>
