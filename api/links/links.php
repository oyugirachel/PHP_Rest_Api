<?php
// include '../database/connection.php';
require 'bootstrap.php';


// SQL query to select links from the 'videos' table
$sql = "SELECT link FROM videos";

$result = $conn->query($sql);

$links = array(); // Initialize an array to store links

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $links[] = $row["link"];
    }

    // Output the array of links as JSON
    echo json_encode($links);
} else {
    // Output JSON for an empty result
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
