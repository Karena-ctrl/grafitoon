<?php
require 'Database_Connection.php';

// Enable error reporting for debugging (you can remove this in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get data from AJAX request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate inputs
    if (empty($name) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data successfully inserted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    }
}

$conn->close();
?>