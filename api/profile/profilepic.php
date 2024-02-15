<?php
include '../database/connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume userIdentifier is sent as a POST parameter
$userIdentifier = $_POST['loadedUserIdentifier'] ?? '';

// Validate userIdentifier to prevent SQL injection
$userIdentifier = mysqli_real_escape_string($conn, $userIdentifier);

// SQL query to fetch profilePic based on userIdentifier
$sql = "SELECT profilePic FROM patients WHERE PatientID = '$userIdentifier'";

// Execute query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Check if profilePic exists
    if ($result->num_rows > 0) {
        // Fetch the BLOB data from the database
        $row = $result->fetch_assoc();
        $blobData = file_get_contents($row['profilePic']);

        // Return the BLOB data as the response
        echo base64_encode($blobData);
    } else {
        echo "No profile picture found for the specified user.";
    }
} else {
    // Output an error message if the query fails
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

// Close connection
$conn->close();
?>
