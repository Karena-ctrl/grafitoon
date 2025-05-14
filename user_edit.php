<?php
session_start();
require 'Database_Connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID not specified.");
}

$user_id = intval($_GET['id']);
$user = null;

// Fetch user
$stmt = $conn->prepare("SELECT name, email, role FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("User not found.");
}
$user = $result->fetch_assoc();
$stmt->close();

// Update on POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'Grafitoon_admin.php';</script>";
    } else {
        echo "Failed to update user.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; padding: 2rem; background: #f0f0f0; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<h2>Edit User</h2>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label>Role:</label>
    <select name="role">
        <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>

    <button type="submit">Update User</button>
</form>

</body>
</html>
