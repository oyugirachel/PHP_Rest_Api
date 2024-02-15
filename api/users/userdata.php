<?php
// Include connection.php to establish a database connection
// include '../database/connection.php';

require 'bootstrap.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume userIdentifier is sent as a POST parameter
$userIdentifier = $_POST['loadedUserIdentifier'] ?? '';

// Validate userIdentifier to prevent SQL injection
$userIdentifier = mysqli_real_escape_string($conn, $userIdentifier);

// SQL query to fetch data based on userIdentifier
$sql = "SELECT p.`FullName`, p.`UserName`, p.`Password`, p.`Phone`, p.`Email`, p.`EmergencyContactInformation`, p.`MedicalHistory`
        FROM `patients` p
        WHERE p.`PatientID` = '$userIdentifier'";

// Execute query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch data and output
    $row = $result->fetch_assoc();

    // Create an array with the required fields
    $data = array(
        "fullName" => $row["FullName"],
        "userName" => $row["UserName"],
        "phone" => $row["Phone"],
        "email" => $row["Email"],
        "emergencyContactInformation" => $row["EmergencyContactInformation"],
        "medicalHistory" => $row["MedicalHistory"]
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

// Close connection
$conn->close();
?>
