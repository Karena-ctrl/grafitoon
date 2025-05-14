<?php
session_start();

// Get order details from session
$order_id = $_SESSION['last_order_id'] ?? null;
$order_total = $_SESSION['last_order_total'] ?? 0.00;



// Optionally clear the temp data after displaying
if (isset($_SESSION['last_order_id'])) unset($_SESSION['last_order_id']);
if (isset($_SESSION['last_order_total'])) unset($_SESSION['last_order_total']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .popup {
            background: white;
            padding: 2em;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            text-align: center;
        }
        .popup h1 {
            color: #28a745;
            font-size: 28px;
        }
        .popup p {
            margin: 10px 0;
            font-size: 16px;
        }
        .popup a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
        .popup a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="popup">
    <h1>Success! Your order was placed.</h1>
    <p><strong>Order ID:</strong> #<?= htmlspecialchars($order_id) ?></p>
    <p><strong>Total Amount:</strong> $<?= number_format($order_total, 2) ?></p>
    <p>Thank you for shopping with us!</p>
    <a href="Grafitoon_ordershistory.php">View Order History</a>
</div>

</body>
</html>
