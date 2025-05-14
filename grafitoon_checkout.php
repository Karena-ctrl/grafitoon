<?php
ob_start();
session_start();

require_once "Database_Connection.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$subtotal = 0;
$shipping = 10;
$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $order_date = date("Y-m-d H:i:s");
    $status = "Processing";

    // Calculate subtotal
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'];
    }
    $total = $subtotal + $shipping;

    // Insert order
    $order_sql = "INSERT INTO Orders (user_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("isds", $user_id, $order_date, $total, $status);
    
    if ($order_stmt->execute()) {
        $order_id = $order_stmt->insert_id;

        // Insert order items
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $item_sql = "INSERT INTO Order_Items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $item_stmt = $conn->prepare($item_sql);
            $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $item_stmt->execute();
        }

        // Clear cart and redirect
         $_SESSION['last_order_id'] = $order_id;
        $_SESSION['last_order_total'] = $total;
        unset($_SESSION['cart']); // optional: clear cart
        header("Location: order_success.php");
        exit();

    } else {
        echo "Error processing order. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Grafitoon</title>
    <link rel="stylesheet" href="grafitoon_css.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(223, 202, 13);
            color: #222;
        }
        header {
            background-color: #000;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 30px;
            gap: 30px;
        }
        .form-section, .summary-section {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 300px;
            max-width: 550px;
        }
        h2 {
            color: #111;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .input-group-row {
            display: flex;
            gap: 15px;
        }
        .input-group-row input {
            flex: 1;
        }
        .checkbox-group {
            margin-top: 15px;
        }
        .order-items {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .order-summary-values p {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .btn {
            display: block;
            width: 100%;
            background-color: #ff6600;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #cc5200;
        }
        .payment-icons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .payment-icons span {
            background: #eee;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }
        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<header>
    <h1>Checkout - Grafitoon</h1>
</header>

<div class="hero">
    <h1>Complete Your Order</h1>
    <p>Secure your items and enjoy your shopping experience!</p>
        
</div>


<div class="checkout-container">
    <form class="form-section" method="POST">
        <h2>Contact Information</h2>
        <label>Email</label>
        <input type="email" name="email" required>

        <div class="checkbox-group">
            <label><input type="checkbox" name="newsletter"> Email me with news and offers</label>
        </div>

        <h2>Billing Address</h2>
        <label>Country</label>
        <select name="country" required>
            <option value="Jamaica" selected>Jamaica</option>
            <option value="USA">USA</option>
            <option value="Canada">Canada</option>
        </select>

        <label>First Name</label>
        <input type="text" name="fname" required>

        <label>Last Name</label>
        <input type="text" name="lname" required>

        <label>Address</label>
        <input type="text" name="address" required>

        <label>Apartment, suite, etc. (optional)</label>
        <input type="text" name="apt">

        <label>City</label>
        <input type="text" name="city" required>

        <label>Phone (optional)</label>
        <input type="tel" name="phone">

        <div class="checkbox-group">
            <label><input type="checkbox" name="save_info"> Save this info for next time</label>
        </div>

        <h2>Payment</h2>
        <p>All transactions are secure and encrypted.</p>

        <label>Credit Card/ Debit Card</label>
       

        <label>Card Number</label>
        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>

        <label>Name on Card</label>
        <input type="text" name="card_name" required>

        <div class="input-group-row">
            <div>
                <label>Expiry Date</label>
                <input type="text" name="card_expiry" placeholder="MM/YY" required>
            </div>
            <div>
                <label>CVV</label>
                <input type="text" name="card_cvv" placeholder="123" required>
            </div>
        </div>

        <div class="checkbox-group">
            <label><input type="checkbox" name="billing_same"> Use shipping address as billing address</label>
        </div>
 <div class="payment-icons">
            <span>Visa</span>
            <span>MasterCard</span>
            <span>American Express</span>
            <span>PayPal</span>
            <span>Afterpay</span>
            <span>Klarna</span>
</div>

        <h2>Shipping Method</h2>
        <p>Choose your shipping method.</p>
        <label><input type="radio" name="shipping_method" value="standard" checked> Standard Shipping - $10</label>
        <label><input type="radio" name="shipping_method" value="express"> Express Shipping - $20</label>

        <div class="checkbox-group">
            <label><input type="checkbox" name="terms" required> I agree to the terms and conditions</label>
        </div>
    <div class="form-section">
        <h2>Shipping Address</h2>
        <p>Make sure your address is correct.</p>
        <label>Country</label>
        <input type="text" name="shipping_country" value="Jamaica" readonly>

        <label>First Name</label>
        <input type="text" name="shipping_fname" required>

        <label>Last Name</label>
        <input type="text" name="shipping_lname" required>

        <label>Address</label>
        <input type="text" name="shipping_address" required>

        <label>Apartment, suite, etc. (optional)</label>
        <input type="text" name="shipping_apt">

        <label>City</label>
        <input type="text" name="shipping_city" required>

        <label>Phone (optional)</label>
        <input type="tel" name="shipping_phone">
<br>

    <div class="summary-section">
        <h2>Order Summary</h2>
        <ul class="order-items">
            <?php
            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                echo "<li class='order-item'><span>{$item['name']}</span><span>\${$item['price']}</span></li>";
                $subtotal += $item['price'];
            }
            $shipping = 10;
            $total = $subtotal + $shipping;
            ?>
        </ul>
        <div class="order-summary-values">
            <p><strong>Subtotal:</strong> <span>$<?= number_format($subtotal, 2) ?></span></p>
            <p><strong>Shipping:</strong> <span>$<?= number_format($shipping, 2) ?></span></p>
            <p><strong>Total:</strong> <span>$<?= number_format($total, 2) ?></span></p>
        </div>
                   
           

       
        <p>By placing your order, you agree to our <a href="#">Terms of Service</a>.</p>
        <p>We accept all major credit cards and PayPal.</p>
        <p>Need help? <a href="Grafitoon_contactus.php">Contact us</a></p>
        <form action="order_success.php" method="POST">
    <button class="btn" type="submit" name="submit_order" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
        Place Order
        

    </button>
            
        <p>Thank you for shopping with us!</p>
    </div>
       
</form> 

</body>
</html>

<?php ob_end_flush(); ?>