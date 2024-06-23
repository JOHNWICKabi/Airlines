<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

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

$user_id = $_SESSION['user_id'];

// Fetch user details from the CUSTOMER table
$sql = "SELECT * FROM CUSTOMER WHERE USER_ID = :user_id";
$statement = oci_parse($connection, $sql);
oci_bind_by_name($statement, ':user_id', $user_id);
oci_execute($statement);

// Fetch the user details
$userDetails = oci_fetch_assoc($statement);

// Process the form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated values from the form
    $updatedFirstName = $_POST['updated_first_name'];
    $updatedLastName = $_POST['updated_last_name'];
    $updatedAddress = $_POST['updated_address'];
    $updatedPhoneNumber = $_POST['updated_phone_number'];

    // Update the user details in the database
    $updateSql = "UPDATE CUSTOMER SET F_NAME = :updated_first_name, L_NAME = :updated_last_name, ADDRESS = :updated_address, PHONE_NO = :updated_phone_number WHERE USER_ID = :user_id";
    $updateStatement = oci_parse($connection, $updateSql);

    oci_bind_by_name($updateStatement, ':updated_first_name', $updatedFirstName);
    oci_bind_by_name($updateStatement, ':updated_last_name', $updatedLastName);
    oci_bind_by_name($updateStatement, ':updated_address', $updatedAddress);
    oci_bind_by_name($updateStatement, ':updated_phone_number', $updatedPhoneNumber);
    oci_bind_by_name($updateStatement, ':user_id', $user_id);

    // Execute the update statement
    if (oci_execute($updateStatement)) {
        // Refresh the user details after the update
        $sql = "SELECT * FROM CUSTOMER WHERE USER_ID = :user_id";
        $statement = oci_parse($connection, $sql);
        oci_bind_by_name($statement, ':user_id', $user_id);
        oci_execute($statement);

        // Fetch the updated user details
        $userDetails = oci_fetch_assoc($statement);
        echo "User details updated successfully.";
    } else {
        echo "Error updating user details.";
    }

    oci_free_statement($updateStatement);
}

oci_free_statement($statement);
oci_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Add your styles or link to an external stylesheet here -->
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB013.jpg'); /* Replace 'your_background_image.jpg' with the path to your image */
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

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        .user-info {
            text-align: left;
        }

        .update-form {
            margin-top: 20px;
        }

        .update-form label,
        .update-form input {
            margin-bottom: 10px;
        }

        .update-form button {
            background-color: #db1c0b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-form button:hover {
            background-color: #db1c0b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Details</h2>

    <div class="user-info">
        <label for="c_id">Customer ID:</label>
        <span id="c_id"><?php echo $userDetails['C_ID']; ?></span>

        <label for="f_name">First Name:</label>
        <span id="f_name"><?php echo $userDetails['F_NAME']; ?></span>

        <label for="l_name">Last Name:</label>
        <span id="l_name"><?php echo $userDetails['L_NAME']; ?></span>

        <label for="address">Address:</label>
        <span id="address"><?php echo $userDetails['ADDRESS']; ?></span>

        <label for="sex">Sex:</label>
        <span id="sex"><?php echo $userDetails['SEX']; ?></span>

        <label for="phone_no">Phone Number:</label>
        <span id="phone_no"><?php echo $userDetails['PHONE_NO']; ?></span>
    </div>

    <div class="update-form">
        <h3>Update User Info</h3>
        <form action="" method="post">
            <label for="updated_first_name">Updated First Name:</label>
            <input type="text" id="updated_first_name" name="updated_first_name" value="<?php echo $userDetails['F_NAME']; ?>" required>

            <label for="updated_last_name">Updated Last Name:</label>
            <input type="text" id="updated_last_name" name="updated_last_name" value="<?php echo $userDetails['L_NAME']; ?>" required>

            <label for="updated_address">Updated Address:</label>
            <input type="text" id="updated_address" name="updated_address" value="<?php echo $userDetails['ADDRESS']; ?>" required>

            <label for="updated_phone_number">Updated Phone Number:</label>
            <input type="text" id="updated_phone_number" name="updated_phone_number" value="<?php echo $userDetails['PHONE_NO']; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</div>

</body>
</html>
