<?php
// include '../database/connection.php';

require 'bootstrap.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume userIdentifier is sent as a POST parameter
$userIdentifier = isset($_POST['userIdentifier']) ? $_POST['userIdentifier'] : '';

// Validate userIdentifier to prevent SQL injection
$userIdentifier = mysqli_real_escape_string($conn, $userIdentifier);

// SQL query to fetch ScheduledDate, Start, End, profilePic, jobtitleName, and fullname based on userIdentifier from appointments table
$sql = "SELECT a.ScheduledDate, a.Start, a.End, a.Status, e.profilePic, j.jobtitleName, e.fullname
        FROM appointments a
        JOIN employees e ON a.MentalHealthProfessionalID = e.EmployeeID
        JOIN jobtitle j ON e.jobtitleID = j.jobtitleID
        WHERE a.patientID = '$userIdentifier' AND a.Status = 'scheduled'";


// Execute query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Check if any records were found
    if ($result->num_rows > 0) {
        // Fetch the data from the database
        $row = $result->fetch_assoc();

        // Include jobtitleName, fullname, and directly use binary data in base64_encode
        $response = array(
            'ScheduledDate' => $row['ScheduledDate'],
            'Start' => $row['Start'],
            'End' => $row['End'],
            'profilePic' => isset($row['profilePic']) ? base64_encode($row['profilePic']) : '',
            'jobtitleName' => $row['jobtitleName'],
            'fullname' => $row['fullname']
        );

        // Return the response as JSON
        echo json_encode($response);
    } else {
        echo "No records found for the specified userIdentifier.";
    }
} else {
    // Output an error message if the query fails
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

// Close connection
$conn->close();
?>
