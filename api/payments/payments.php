<?php
// include '../database/connection.php';

require 'bootstrap.php';


// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the POST data
    $userIdentifier = $_POST['userIdentifier'];
    $consultationFee = $_POST['consultationFee'];
    $selectedPaymentMethod = $_POST['selectedPaymentMethod'];
    $transactionCode = $_POST['transactionCode'];



    // Prepare and execute the SQL statement with a prepared statement
    $stmt = $conn->prepare("INSERT INTO payments (PatientID, PaymentAmount, PaymentDateTime, PaymentMethod, TransactionID)
                            VALUES (?, ?, NOW(), ?, ?)");

    // Bind parameters
    $stmt->bind_param("siss", $userIdentifier, $consultationFee, $selectedPaymentMethod, $transactionCode);

    // Execute the statement
    if ($stmt->execute()) {
        // Respond with success
        echo "Payment data inserted successfully";
    } else {
        // Respond with an error
        echo "Error inserting payment data";
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();
} else {
    // Respond with an error for non-POST requests
    echo "Invalid request method";
}
?>
