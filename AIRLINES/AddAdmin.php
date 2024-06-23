<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB013.jpg'); /* Add your background image path */
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Background color with opacity */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            margin: 10px 0;
            color: #FFF;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #db1c0b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #424345;
        }
    </style>
</head>
<body>

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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];

    // Validate form data (you can add more validation as needed)
    if (empty($username) || empty($password) || empty($firstName) || empty($lastName) || empty($email)) {
        echo "All fields are required.";
    } else {
        // Add admin to the database (replace the SQL query accordingly)
        $query = "INSERT INTO ADMIN (USERNAME, PASSWORD, FIRST_NAME, LAST_NAME, EMAIL) VALUES ('$username', '$password', '$firstName', '$lastName', '$email')";
        $result = oci_parse($connection, $query);

        if (oci_execute($result)) {
            echo "Admin added successfully.";
        } else {
            echo "Error adding admin.";
        }
    }
}

oci_close($connection);
?>

<!-- Add your HTML form here -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <button type="submit">Add Admin</button>
</form>

</body>
</html>
