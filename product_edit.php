<?php
session_start();
require 'Database_Connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID not specified.");
}

$product_id = intval($_GET['id']);
$product = null;

// Fetch existing product data
$stmt = $conn->prepare("SELECT name, price, image_path, description FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Product not found.");
}
$product = $result->fetch_assoc();
$stmt->close();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $image_path = trim($_POST['image_path']);

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image_path = ?, description = ? WHERE product_id = ?");
    $stmt->bind_param("sdssi", $name, $price, $image_path, $description, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'Grafitoon_admin.php';</script>";
    } else {
        echo "Failed to update product.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; padding: 2rem; background: #f9f9f9; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 10px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h2>Edit Product</h2>

<form method="POST">
    <label>Product Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

    <label>Image Path (URL):</label>
    <input type="text" name="image_path" value="<?= htmlspecialchars($product['image_path']) ?>" required>

    <label>Description:</label>
    <textarea name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>

    <button type="submit">Update Product</button>
</form>

</body>
</html>
