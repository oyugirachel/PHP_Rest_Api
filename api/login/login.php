<?php
// include '../database/connection.php';
require 'bootstrap.php';



// Handle the login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from the request
    $selectedItem = $_POST["selectedItem"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the data (you can add more validation here)
    if (empty($username) || empty($password)) {
        echo "Please enter a username and password.";
        exit();
    }

    // Escape user input to prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Define table and user_id variables
    $table = "";
    $user_id = "";
    $name = "";

    // Determine the table and user ID based on the selected item
    switch ($selectedItem) {
        case "Psychiatrist":
        case "Psychologist":
        case "Counsellor":
        case "Care Coordinator":
        case "Pharmacist":
        case "Hospital Driver":
        case "Finance Officer":
            $table = "Employees";
            $user_id = "EmployeeID";
            $name = "FullName";
            break;
        case "Guardian":
            $table = "Guardian";
            $user_id = "GuardianID";
            $name = "FullName";
            break;
        case "Patient":
            $table = "Patients";
            $user_id = "PatientID";
            $name = "FullName";
            break;
        case "Supplier":
            $table = "Supplier";
            $user_id = "SupplierID";
            $name = "FullName";
            break;
        default:
            echo "Invalid selection.";
            exit();
    }

    // Check if the user exists in the selected table
    $sql = "SELECT * FROM $table WHERE Username = '$username' AND Status = 'Approved'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify the password
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["Password"])) {
            // Retrieve the user ID
            $user_id_value = $row[$user_id];
            session_start();
            $_SESSION["user_id"] = $user_id_value;
            // Retrieve the user name
            $name_value = $row[$name];
            $_SESSION["name"] = $name_value;
            // Send both "Login Successful" and user ID as the response with a delimiter
            echo "Login Successful|$user_id_value|$name_value";
        } else {
            echo "User not found. Check if you entered a correct username and password.";
        }
    } else {
        echo "User not yet approved.";
    }
}

// Close the connection
$conn->close();
?>
