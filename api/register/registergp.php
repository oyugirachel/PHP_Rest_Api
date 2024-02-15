<?php
include '../database/connection.php';

// Handle the registration request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from the request
    $id = $_POST["id"];
    $fullName = $_POST["fullName"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $emergency = $_POST["emergency"];
    $medical = $_POST["medical"];
    $insurance = $_POST["insurance"];

    // Escape user input to prevent SQL injection
    $id = $conn->real_escape_string($id);
    $fullName = $conn->real_escape_string($fullName);
    $dob = $conn->real_escape_string($dob);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);
    $emergency = $conn->real_escape_string($emergency);
    $medical = $conn->real_escape_string($medical);
    $insurance = $conn->real_escape_string($insurance);

    // Insert data into the "Patients" table
    $sql = "INSERT INTO Patients (FullName, DateOfBirth, Phone, Email, EmergencyContactInformation, MedicalHistory, InsuranceInformation, GuardianID, Status) VALUES ('$fullName', '$dob', '$phone', '$email', '$emergency', '$medical', '$insurance', '$id', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Registered Successfully";
    } else {
        echo "Failed, try again";
   }
}

// Close the connection
$conn->close();
?>
