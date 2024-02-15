<?php
// include '../database/connection.php';

require 'bootstrap.php';

// Assuming you have received data from the Flutter app
$employeeID = $_POST['employeeID'];
$userIdentifier = $_POST['userIdentifier'];
$messageContent = $_POST['message'];

// Check if the data is set
if (isset($employeeID, $userIdentifier, $messageContent)) {
    // Set default values for additional columns
    $messageStatus = 'Sent';

    // Insert data into the 'messages' table using NOW() for current date and time
    $sql = "INSERT INTO messages (ReceiverEmployeeID, SenderPatientID, MessageContent, MessageStatus, MessageDateTime)
            VALUES ('$employeeID', '$userIdentifier', '$messageContent', '$messageStatus', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Send a success response back to the Flutter app
        $response = ['status' => 'success', 'message' => 'Data inserted successfully'];
        echo json_encode($response);
    } else {
        // Send an error response back to the Flutter app
        $response = ['status' => 'error', 'message' => 'Error inserting data: ' . $conn->error];
        echo json_encode($response);
    }
} else {
    // Send an error response if data is not set
    $response = ['status' => 'error', 'message' => 'Invalid data received'];
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
