<?php
// include '../database/connection.php';

require 'bootstrap.php';


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume user data is sent as a POST parameter
$loadedUserIdentifier = $_POST['loadedUserIdentifier'] ?? '';
$fullName = $_POST['fullName'] ?? '';
$userName = $_POST['userName'] ?? '';
$passwordInput = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$emergencyContact = $_POST['emergencyContact'] ?? '';
$medicalHistory = $_POST['medicalHistory'] ?? '';
$profilePic = $_POST['profilePic'] ?? ''; 

// Validate userIdentifier to prevent SQL injection
$loadedUserIdentifier = mysqli_real_escape_string($conn, $loadedUserIdentifier);

// Build the SET clause of the SQL query
$setClause = array();
if (!empty($fullName)) {
    $setClause[] = "`FullName` = '$fullName'";
}
if (!empty($userName)) {
    $setClause[] = "`UserName` = '$userName'";
}
if (!empty($passwordInput)) {
    // Hash the password before updating
    $hashedPassword = password_hash($passwordInput, PASSWORD_DEFAULT);
    $setClause[] = "`Password` = '$hashedPassword'";
}
if (!empty($email)) {
    $setClause[] = "`Email` = '$email'";
}
if (!empty($phone)) {
    $setClause[] = "`Phone` = '$phone'";
}
if (!empty($emergencyContact)) {
    $setClause[] = "`EmergencyContactInformation` = '$emergencyContact'";
}
if (!empty($medicalHistory)) {
    $setClause[] = "`MedicalHistory` = '$medicalHistory'";
}
if (!empty($profilePic)) {
    $setClause[] = "`ProfilePic` = '$profilePic'";
}

// Check if there are updates to perform
if (!empty($setClause)) {
    // Build and execute the SQL query
    $setClauseString = implode(', ', $setClause);
    $sql = "UPDATE `patients` SET $setClauseString WHERE `PatientID` = '$loadedUserIdentifier'";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(array("success" => "Data updated successfully"));
    } else {
        echo json_encode(array("error" => "Error updating data: " . $conn->error));
    }
} else {
    echo json_encode(array("info" => "No data to update"));
}

// Close connection
$conn->close();
?>
