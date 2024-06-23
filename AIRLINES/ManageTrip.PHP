<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trips</title>
    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
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
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #db1c0b;
            color: #fff;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .page-link {
            padding: 8px 12px;
            margin: 0 5px;
            background-color: #db1c0b;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .page-link:hover {
            background-color: #db1c0b;
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

    // Pagination
    $rowsPerPage = 10;
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $startRow = ($currentPage - 1) * $rowsPerPage + 1;
    $endRow = $startRow + $rowsPerPage - 1;

    // Fetch and display trips
    $fetchQuery = "SELECT * FROM (
                        SELECT t.*, ROWNUM rnum FROM (
                            SELECT * FROM TRIP
                        ) t
                        WHERE ROWNUM <= :endRow
                    ) WHERE rnum >= :startRow";
    $fetchStatement = oci_parse($connection, $fetchQuery);
    oci_bind_by_name($fetchStatement, ':startRow', $startRow);
    oci_bind_by_name($fetchStatement, ':endRow', $endRow);
    oci_execute($fetchStatement);

    echo '<table>';
    echo '<tr><th>Trip ID</th><th>Flight ID</th><th>From</th><th>To</th><th>Type</th><th>Departure</th><th>Depart Time</th><th>Arrival Time</th><th>Duration</th><th>Stops</th><th>Edit</th></tr>';
    while ($row = oci_fetch_assoc($fetchStatement)) {
        echo '<tr>';
        echo '<td>' . $row['TRIP_ID'] . '</td>';
        echo '<td>' . $row['FLIGHT_ID'] . '</td>';
        echo '<td>' . $row['FROM_'] . '</td>';
        echo '<td>' . $row['TO_'] . '</td>';
        echo '<td>' . $row['TYPE_'] . '</td>';
        echo '<td>' . $row['DEPARTURE'] . '</td>';
        echo '<td>' . $row['DEPART_TIME'] . '</td>';
        echo '<td>' . $row['ARRIVAL_TIME'] . '</td>';
        echo '<td>' . $row['DURATION_'] . '</td>';
        echo '<td>' . $row['STOPS'] . '</td>';
        echo '<td>
                <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                    <input type="hidden" name="trip_id" value="' . $row['TRIP_ID'] . '">
                    <label for="depart_time">New Depart Time:</label>
                    <input type="text" id="depart_time" name="depart_time" required>

                    <label for="arrival_time">New Arrival Time:</label>
                    <input type="text" id="arrival_time" name="arrival_time" required>

                    <button type="submit">Update</button>
                </form>
              </td>';
        echo '</tr>';
    }
    echo '</table>';

    // Pagination links
    $totalRowsQuery = "SELECT COUNT(*) as total FROM TRIP";
    $totalRowsStatement = oci_parse($connection, $totalRowsQuery);
    oci_execute($totalRowsStatement);
    $totalRows = oci_fetch_assoc($totalRowsStatement)['TOTAL'];

    $totalPages = ceil($totalRows / $rowsPerPage);

    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a class="page-link" href="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=' . $i . '">' . $i . '</a>';
    }
    echo '</div>';

    oci_free_statement($totalRowsStatement);
    oci_free_statement($fetchStatement);
    oci_close($connection);
    ?>

</div>

</body>
</html>
