<?php
// include '../database/connection.php';
require 'bootstrap.php';



// SQL query to select title and link from the 'books' table
$sql = "SELECT title, link FROM books";

$result = $conn->query($sql);

$books = array(); // Initialize an array to store books

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Ensure 'title' and 'link' are strings
        $row['title'] = strval($row['title']);
        $row['link'] = strval($row['link']);
        $books[] = $row;
    }

    // Output the array of books as JSON
    echo json_encode($books);
} else {
    // Output JSON for an empty result
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
