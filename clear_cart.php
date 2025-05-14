<?php
session_start();

// Check if the cart exists in the session
if (isset($_SESSION['cart'])) {
    // Remove the cart array from the session
    unset($_SESSION['cart']);

    // Optional: Add a success message
    // $_SESSION['message'] = "Cart cleared successfully.";
}

// Redirect back to the shopping cart page
header("Location: Grafitoon_shoppingcart.php");
exit(); // Ensure script stops execution after redirection
?>