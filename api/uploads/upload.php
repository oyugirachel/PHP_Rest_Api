<?php
require 'bootstrap.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_FILES['image'];
    
    // Check if the file is uploaded successfully
    if ($image['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $image['tmp_name'];
        $name = $image['name'];
        
        // Move the uploaded file to a designated location
        move_uploaded_file($tmp_name, 'uploads/' . $name);

        // Image path for the 'profilePic' column
        $imagePath = 'uploads/' . $name;

        // Insert the image file path into the database for patient with patientID 10
        $patientID = 10;
        $sql = "UPDATE patients SET profilePic = '$imagePath' WHERE patientID = $patientID";
        
        if ($conn->query($sql) === TRUE) {
            // Fetch the BLOB data from the database
            $selectSql = "SELECT profilePic FROM patients WHERE patientID = $patientID";
            $result = $conn->query($selectSql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $blobData = file_get_contents($row['profilePic']);

                // Return the BLOB data as the response
                echo base64_encode($blobData);
            } else {
                echo "No records found";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file. Code: " . $image['error'];
    }
}

$conn->close();
?>
