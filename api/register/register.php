<?php
include '../database/connection.php';


// Handle the registration request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from the request
    $selectedItem = $_POST["selectedItem"];
    $fullName = $_POST["fullName"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate the data (you can add more validation here)
    if (empty($fullName) || empty($dob) || empty($phone) || empty($email) || empty($password)) {
        echo "Please fill all the fields.";
        exit();
    }

    // Escape user input to prevent SQL injection
    $fullName = $conn->real_escape_string($fullName);
    $dob = $conn->real_escape_string($dob);
    $phone = $conn->real_escape_string($phone);
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Hash the password (you should use a more secure hashing mechanism)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $table = ""; // Initialize the $table variable
    $jobTitleID = null;
    $departmentID = null;

    switch ($selectedItem) {
        case "Psychiatrist":
            $table = "Employees";
            $jobTitleID = 1;
            $departmentID = 1;
            break;
        case "Psychologist":
            $table = "Employees";
            $jobTitleID = 2;
            $departmentID = 2;
            break;
        case "Counsellor":
            $table = "Employees";
            $jobTitleID = 3;
            $departmentID = 3;
            break;
        case "Care Coordinator":
            $table = "Employees";
            $jobTitleID = 4;
            $departmentID = 4;
            break;
        case "Pharmacist":
            $table = "Employees";
            $jobTitleID = 5;
            $departmentID = 5;
            break;
        case "Hospital Driver":
            $table = "Employees";
            $jobTitleID = 6;
            $departmentID = 6;
            break;
        case "Finance Officer":
            $table = "Employees";
            $jobTitleID = 7;
            $departmentID = 7;
            break;
        case "Guardian":
            $table = "Guardian";
            break;
        case "Patient":
            $table = "Patients";
            break;
        case "Supplier":
            $table = "Supplier";
            break;
        default:
            echo "Invalid selection.";
            exit();
    }

    // Insert data into the appropriate table
    if ($table === "Employees") {
        $sql = "INSERT INTO $table (FullName, DateOfBirth, Phone, Username, Email, Password, Status, JobTitleID, DepartmentID) VALUES ('$fullName', '$dob', '$phone', '$username', '$email', '$hashedPassword', 'Pending', $jobTitleID, $departmentID)";
    } else {
        $sql = "INSERT INTO $table (FullName, DateOfBirth, Phone, Username, Email, Password, Status) VALUES ('$fullName', '$dob', '$phone', '$username', '$email', '$hashedPassword', 'Pending')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Registered Successfully";
    } else {
        echo "Failed, try again";
    }
}

// Close the connection
$conn->close();
?>
