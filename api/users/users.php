<?php
include '../database/connection.php';


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// SQL query
$sql = "SELECT e.`EmployeeID`, e.`FullName`, j.`JobTitleName`, e.`ProfilePic`
        FROM `employees` e
        JOIN `jobtitle` j ON e.`JobTitleID` = j.`JobTitleID`";

// Execute query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch data and output
    $data = array();
    while ($row = $result->fetch_assoc()) {
        // Check if ProfilePic is empty
        $profilePic = $row["ProfilePic"] ? base64_encode($row["ProfilePic"]) : null;

        // Generate random average review between 3 and 5
        $averageReview = mt_rand(3, 5);

        $data[] = array(
            "employeeID" => $row["EmployeeID"],
            "fullName" => $row["FullName"],
            "jobTitle" => $row["JobTitleName"],
            "averageReview" => $averageReview,
            "profilePic" => $profilePic,
        );
    }

    // Convert the data array to JSON
    $json_data = json_encode($data);

    // Output the JSON data
    echo $json_data;
} else {
    // Output an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
