<?php
session_start();
require 'Database_Connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $image_path = trim($_POST['image_path']);
    $description = trim($_POST['description']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (name, price, image_path, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $image_path, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Product created successfully!'); window.location.href = 'Grafitoon_admin.php';</script>";
    } else {
        echo "Failed to create product.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Product</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color:rgb(244, 244, 244);
        }
        form {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Create New Product</h2>

<form method="POST">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required>

    <label for="price">Price:</label>
    <input type="number" name="price" step="0.01" required>

    <label for="image_path">Image Path (URL or file path):</label>
    <input type="text" name="image_path" required>

    <label for="description">Description:</label>
    <textarea name="description" rows="5"></textarea>

    <button type="submit">Create Product</button>
</form>

</body>
</html>
