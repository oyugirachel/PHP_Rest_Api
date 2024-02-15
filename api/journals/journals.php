<?php
// include '../database/connection.php';

require 'bootstrap.php';


// SQL query to select title and link from the 'journals' table
$sql = "SELECT title, link FROM journals";

$result = $conn->query($sql);

$journals = array(); // Initialize an array to store journals

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Ensure 'title' and 'link' are strings
        $row['title'] = strval($row['title']);
        $row['link'] = strval($row['link']);
        $journals[] = $row;
    }

    // Output the array of journals as JSON
    echo json_encode($journals);
} else {
    // Output JSON for an empty result
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
