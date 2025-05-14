<?php

include_once(__DIR__ . '/config.php');
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: grafitoon_login.php");
    exit();
}


// Redirect non-admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: grafitoon_login.php");
    exit();
}

// Delete product
if (isset($_GET['delete_product'])) {
    $id = intval($_GET['delete_product']);
    $conn->query("DELETE FROM products WHERE product_id = $id");
    header("Location: Grafitoon_admin.php");
    exit();
}

// Delete user
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);
    $conn->query("DELETE FROM users WHERE user_id = $id");
    header("Location: Grafitoon_admin.php");
    exit();
}

// Fetch products and users
$products = $conn->query("SELECT * FROM products");
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Grafitoon</title>
    <link rel="stylesheet" href="grafitoon_css.css">
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
        a.btn { padding: 5px 10px; margin: 0 2px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .edit { background-color: #2196F3; color: white; }
        .delete { background-color: #f44336; color: white; }
        .add { background-color: #4CAF50; color: white; display: inline-block; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</h1>

    <h2>Products</h2>
    <a href="admin_create_product.php" class="btn add">+ Add Product</a>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Image</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $row['product_id'] ?></td>
                <td><?= htmlspecialchars($row['NAME']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><img src="<?= $row['image_path'] ?>" width="50"></td>
                <td>
                    <a href="product_edit.php?id=<?= $row['product_id'] ?>" class="btn edit">Edit</a>
                    <a href="?delete_product=<?= $row['product_id'] ?>" class="btn delete" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Users</h2>
    <a href="admin_create_user.php" class="btn add">+ Add User</a>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <a href="user_edit.php?id=<?= $row['user_id'] ?>" class="btn edit">Edit</a>
                    <a href="?delete_user=<?= $row['user_id'] ?>" class="btn delete" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<!-- Back to Home Button -->
<div style="text-align: center; margin-top: 15px;">
    <a href="Grafitoon_index.php" style="display:inline-block; background-color:#6c757d; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">Back to Home</a>
</div>
</body>
</html>
