<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('AB011.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;     
            background-color: #42413f;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: rgba(255, 165, 0, 0.8); /* Orange background color with some transparency */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow effect */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #fff; /* Label text color */
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #db1c0b; /* Orange button color */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #42413f; /* Darker orange color on hover */
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

// Handle admin login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = $_POST["admin_id"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate admin credentials and log in
    $query = "SELECT * FROM ADMIN WHERE ADMIN_ID = :adminId AND USERNAME = :username AND PASSWORD = :password";
    $result = oci_parse($connection, $query);
    oci_bind_by_name($result, ':adminId', $adminId);
    oci_bind_by_name($result, ':username', $username);
    oci_bind_by_name($result, ':password', $password);
    oci_execute($result);

    // Check if login is successful
    if (oci_fetch_assoc($result)) {
        // Admin login successful
        $_SESSION['admin_id'] = $adminId;

        // Insert into ADMINLOGS
        $insertLogQuery = "INSERT INTO ADMINLOGS (ADMIN_ID, LOG_TIME) VALUES (:adminId, CURRENT_TIMESTAMP)";
$insertLogStatement = oci_parse($connection, $insertLogQuery);
oci_bind_by_name($insertLogStatement, ':adminId', $adminId);

if (oci_execute($insertLogStatement)) {
    echo "Log entry added successfully.";
} else {
    echo "Error adding log entry: " . oci_error($insertLogStatement);
}


        header("Location: admin_home.php"); // Redirect to admin home
        exit();
    } else {
        echo "Invalid credentials. Please try again.";
    }
}

oci_close($connection);
?>

<!-- Add your HTML form here -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="admin_id">Admin ID:</label>
    <input type="text" id="admin_id" name="admin_id" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>

</body>
</html>
