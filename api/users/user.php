<?php
// include '../database/connection.php';
require 'bootstrap.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume userIdentifier is sent as a POST parameter
$userIdentifier = $_POST['loadedUserIdentifier'] ?? null;

if ($userIdentifier !== null) {
    // Validate userIdentifier to prevent SQL injection
    $userIdentifier = mysqli_real_escape_string($conn, $userIdentifier);

    // SQL query to fetch data based on userIdentifier
    $sql = "SELECT p.`FullName`, p.`ProfilePic`
            FROM `patients` p
            WHERE p.`PatientID` = '$userIdentifier'";

    // Execute query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch data and output
        $row = $result->fetch_assoc();

        // Check if ProfilePic is not empty
        $profilePic = $row["ProfilePic"] ? base64_encode($row["ProfilePic"]) : null;

        // Create a single associative array with 'fullName' and 'profilePic'
        $data = array(
            "fullName" => $row["FullName"],
            "profilePic" => $profilePic,
        );

        // Convert the data array to JSON
        $json_data = json_encode($data);

        // Output the JSON data
        header('Content-Type: application/json');
        echo $json_data;
    } else {
        // Output an error message if the query fails
        echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
    }
} else {
    // Output an error message if userIdentifier is not provided
    echo json_encode(array("error" => "User identifier not provided."));
}

// Close connection
$conn->close();
?>
