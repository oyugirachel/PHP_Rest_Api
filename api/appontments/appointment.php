<?php
// include '../database/connection.php';

require 'bootstrap.php';

// Get data from the POST request
$userIdentifier = $_POST['userIdentifier'] ?? '';
$employeeID = $_POST['employeeID'] ?? '';
$mentalIllnessInput = $_POST['mentalIllnessInput'] ?? '';

// Validate required data
if (empty($userIdentifier) || empty($employeeID) || empty($mentalIllnessInput)) {
    http_response_code(400); // Bad Request
    echo 'Missing required data';
    exit;
}



// Get the current date and time
$currentDate = date('Y-m-d H:i:s');

// Prepare and execute SQL query to insert data into the appointments table
$stmt = $conn->prepare("INSERT INTO appointments (patientID, MentalHealthProfessionalID, illness, RequestDate) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $userIdentifier, $employeeID, $mentalIllnessInput, $currentDate);

if ($stmt->execute()) {
    echo 'Appointment request processed successfully';
} else {
    echo 'Failed to insert data into the appointments table';
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
