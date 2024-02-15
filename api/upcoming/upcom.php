<?php

// Assuming loadedUserIdentifier is set in Flutter and sent to the server
$userIdentifier = 10;

// include '../database/connection.php';
require 'bootstrap.php';


// Your SQL query
$sql = "SELECT a.ScheduledDate, a.Start, a.End, a.Status, CONVERT(e.profilePic USING utf8) as profilePic, j.jobtitleName, e.fullname
        FROM appointments a
        JOIN employees e ON a.MentalHealthProfessionalID = e.EmployeeID
        JOIN jobtitle j ON e.jobtitleID = j.jobtitleID
        WHERE a.patientID = '$userIdentifier' AND a.Status = 'scheduled'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Build a custom response array
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'ScheduledDate' => $row['ScheduledDate'],
            'Start' => $row['Start'],
            'End' => $row['End'],
            'profilePic' => base64_encode($row['profilePic']),
            'jobtitleName' => $row['jobtitleName'],
            'fullname' => $row['fullname']
        ];
    }

    // Return the response as JSON with the 'data' key
    echo json_encode(['data' => $response]);
} else {
    // No results found, echo a simple message
    echo json_encode(['message' => 'No upcoming appointments found for the user.']);
}

// Close the connection
$conn->close();

?>
