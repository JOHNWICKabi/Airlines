<?php
$config = include('config.php');

$host = $config['host'];
$port = $config['port'];
$service_name = $config['service_name'];
$oracleUsername = $config['username'];
$oraclePassword = $config['password'];

$connStr = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))(CONNECT_DATA = (SERVICE_NAME = $service_name)))";
$connection = oci_connect($oracleUsername, $oraclePassword, $connStr);

if (!$connection) {
    $error = oci_error();
    die("Connection failed: " . $error['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['first_name']) && isset($_POST['last_name']) &&
        isset($_POST['address']) && isset($_POST['sex']) &&
        isset($_POST['phone_no']) && isset($_POST['username']) &&
        isset($_POST['password'])
    ) {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $address = $_POST['address'];
        $sex = $_POST['sex'];
        $phoneNo = $_POST['phone_no'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "INSERT INTO customer (C_ID, F_NAME, L_NAME, ADDRESS, SEX, PHONE_NO, user_id, user_pwd) 
                  VALUES (customer_seq.NEXTVAL, :first_name, :last_name, :address, :sex, :phone_no, :username, :password)";
        $stmt = oci_parse($connection, $query);
        oci_bind_by_name($stmt, ":first_name", $firstName);
        oci_bind_by_name($stmt, ":last_name", $lastName);
        oci_bind_by_name($stmt, ":address", $address);
        oci_bind_by_name($stmt, ":sex", $sex);
        oci_bind_by_name($stmt, ":phone_no", $phoneNo);
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":password", $password);

        $result = oci_execute($stmt);

        if ($result) {
            // Redirect to login.php
            header("Location: login.php");
            exit();
        } else {
            echo "Error during sign up.";
        }

        oci_free_statement($stmt);
    } else {
        echo "All fields are required for sign up.";
    }
}

oci_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('SIGNIN1.jpg'); 
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        form {
            width: 300px;
            margin: auto;
            margin-top: 100px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #7032b8;
        }

        label {
            color: #fff;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #fff;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #fff;
            border-radius: 4px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            background: #7032b8;
            color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form action="" method="post">
        <h2>Sign Up</h2>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <label for="sex">Sex:</label>
        <select id="sex" name="sex" required>
            <option value="MALE">Male</option>
            <option value="FEMALE">Female</option>
        </select>
        <label for="phone_no">Phone Number:</label>
        <input type="text" id="phone_no" name="phone_no" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
