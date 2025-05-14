<?php
session_start();

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $productIdToRemove = $_GET['id'];

    // Check if the cart exists and the item is in the cart
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$productIdToRemove])) {
        // Remove the item from the session cart array
        unset($_SESSION['cart'][$productIdToRemove]);

        // Optional: Add a success message (using sessions or query params)
        // $_SESSION['message'] = "Item removed successfully.";
    } else {
        // Optional: Add an error message if item not found
        // $_SESSION['error'] = "Item not found in cart.";
    }
} else {
    // Optional: Add an error message if ID is missing
    // $_SESSION['error'] = "Product ID missing.";
}

// Redirect back to the shopping cart page
header("Location: Grafitoon_shoppingcart.php");
exit(); // Ensure script stops execution after redirection
?>