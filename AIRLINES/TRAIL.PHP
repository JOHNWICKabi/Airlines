<?php
// Initialize variables for form data
$events = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_event'])) {
    // Retrieve form data
    $eid = isset($_POST['eid']) ? $_POST['eid'] : 1; // Assuming Eid is provided in the form
    $ename = $_POST['ename'];
    $entry_fees = $_POST['entry_fees'];
    $etype = $_POST['etype'];
    $elocation = $_POST['elocation'];
    $edate = $_POST['edate'];
    $etime = $_POST['etime'];
    $slots = $_POST['slots'];
    $total_members = $_POST['total_members'];

    // Create an array for the current event
    $event = [
        'Eid' => $eid,
        'Ename' => $ename,
        'Entry_fees' => $entry_fees,
        'EType' => $etype,
        'ELocation' => $elocation,
        'EDate' => $edate,
        'ETime' => $etime,
        'Slots' => $slots,
        'Total_members' => $total_members
    ];

    // Load existing events from JSON file
    if (file_exists('events.json')) {
        $events = json_decode(file_get_contents('events.json'), true);
    }

    // Check if the event with the same Eid already exists
    $eventExists = false;
    foreach ($events as $key => $existingEvent) {
        if ($existingEvent['Eid'] == $eid) {
            $eventExists = true;
            // Update existing event
            $events[$key] = $event;
            break;
        }
    }

    // If event doesn't exist, add it to the events array
    if (!$eventExists) {
        $events[] = $event;
    }

    // Save the updated events array back to the JSON file
    file_put_contents('events.json', json_encode($events));

    echo "Event saved successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Event Updation form</title>
    <style>
        /* Your CSS styles here */
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"],
        .button {
            width: 45%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover,
        .button:hover {
            background-color: #45a049;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="container">
        <h2>Admin Event Updation form</h2>
        <form id="eventForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php
            // Determine the next Eid by counting existing events
            $next_eid = count($events) + 1;
            ?>
                <input type="hidden" name="eid" value="<?php echo $next_eid; ?>">
                <input type="text" name="ename" placeholder="Event Name" required><br>
                <input type="number" name="entry_fees" placeholder="Entry Fees" required><br>
                <input type="text" name="etype" placeholder="Event Type" required><br>
                <input type="text" name="elocation" placeholder="Event Location" required><br>
                <input type="date" name="edate" placeholder="Event Date" required><br>
                <input type="time" name="etime" placeholder="Event Time" required><br>
                <input type="number" name="slots" placeholder="Slots" required><br>
                <input type="number" name="total_members" placeholder="Total Members" required><br>
                <input type="submit" name="save_event" value="SAVE">
                <div class="button-container">
                    <button class="button" type="button" onclick="nextStep(2)">Next</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function nextStep(step) {
            // Create a new form for the next step
            var currentForm = document.getElementById('eventForm');
            var newForm = currentForm.cloneNode(true);
            newForm.id = 'eventForm' + step;
            newForm.action = '';
            // Hide the current form
            currentForm.style.display = 'none';
            // Append the new form to the document
            document.body.appendChild(newForm);
            // Submit the new form to proceed to the next step
            newForm.submit();
        }
    </script>
</body>
</html>
