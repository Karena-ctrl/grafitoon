<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $product_id = $_POST['product_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    $image_url = $_POST['image_url'] ?? '';

    if ($product_id && is_numeric($quantity)) {
        // Add or update product in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'image_url' => $image_url
            ];
        }
        echo 'added';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid';
}
