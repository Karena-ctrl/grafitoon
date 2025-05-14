<?php
session_start();
include 'Database_Connection.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: Grafitoon_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$products = [
    1 => ["img" => "images/whitetshirt.png", "name" => "Custom Tee", "price" => "25.00", "description" => "A bold custom tee with cartoon graffiti style."],
    2 => ["img" => "images/hoodie.png", "name" => "Custom Hoodie", "price" => "40.00", "description" => "Stay cozy with this graffiti hoodie dripping in vibes."],
    3 => ["img" => "images/cap.png", "name" => "Custom Cap", "price" => "18.00", "description" => "Top off your fit with this bold cap."],
    4 => ["img" => "images/slides.png", "name" => "Custom Slides", "price" => "15.45", "description" => "Slide into comfort and style."],
    5 => ["img" => "images/blueshorts.png", "name" => "Custom Shorts", "price" => "19.00", "description" => "Vibrant blue shorts perfect for sunny days."],
    6 => ["img" => "images/sweater.png", "name" => "Custom Sweater", "price" => "18.00", "description" => "Keep it warm, keep it GrafiToon."],
];

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $products[$product_id] ?? null;

if (!$product) {
    echo "<h2 style='text-align:center;'>Product not found.</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> - Grafitoon</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="grafitoon_css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    header, footer {
      background: #000;
      color: white;
      text-align: center;
      padding: 15px;
    }
    nav {
      background-color: #131313;
      text-align: center;
      padding: 10px;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
    }
    .product-detail {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      align-items: center;
    }
    .product-detail img {
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
    }
    .product-info {
      flex: 1;
    }
    .product-info h2 {
      margin: 0 0 10px;
    }
    .product-info p {
      font-size: 16px;
      color: #444;
    }
    .btn {
      background: #ff6600;
      color: white;
      padding: 12px 25px;
      border-radius: 25px;
      text-decoration: none;
      margin-top: 15px;
      border: none;
      cursor: pointer;
    }
    #cartResponse {
      margin-top: 10px;
      color: green;
      font-weight: bold;
    }
    .profile-dropdown {
      display: inline-block;
      position: relative;
    }
    .profile-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
    }
    .profile-dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      border-radius: 10px;
      overflow: hidden;
      z-index: 1000;
    }
    .profile-dropdown-content a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
    }
    .profile-dropdown:hover .profile-dropdown-content {
      display: block;
    }
  </style>
</head>
<body>
  <header>
    <img src="images/logo.jpg" alt="Grafitoon Logo" width="150">
  </header>

  <nav>
    <a href="Grafitoon_index.php">Home</a>
    <a href="about_us.php">About</a>
    <a href="Grafitoon_shoppingsection.php">Shop</a>
    <a href="Grafitoon_contactus.php">Contact</a>
    <a href="Grafitoon_shoppingcart.php"><i class="fas fa-shopping-cart"></i></a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="profile-dropdown">
            <img src="<?= htmlspecialchars($_SESSION['profile_picture'] ?? 'images/placeholders/default_profile.png') ?>" class="profile-avatar" alt="Profile">
            <div class="profile-dropdown-content">
                <a href="Grafitoon_profile.php"><i class="fas fa-user"></i> My Profile</a>
                <a href="grafitoon_checkout.php"><i class="fas fa-credit-card"></i> Checkout</a>
                <a href="Grafitoon_ordershistory.php"><i class="fas fa-history"></i> Order History</a>
                <?php if ($_SESSION['role'] ?? '' === 'admin'): ?>
                    <a href="Grafitoon_admin.php"><i class="fas fa-tools"></i> Admin Dashboard</a>
                <?php endif; ?>
                <a href="#" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
            </div>
        </div>
    <?php else: ?>
        <a href="Grafitoon_login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
    <?php endif; ?>
  </nav>

  <div class="product-detail">
    <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <div class="product-info">
      <h2><?= htmlspecialchars($product['name']) ?></h2>
      <p><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>
      <p><?= htmlspecialchars($product['description']) ?></p>

      <form id="addToCartForm">
          <input type="hidden" name="product_id" value="<?= $product_id ?>">
          <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
          <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">
          <input type="hidden" name="image_url" value="<?= htmlspecialchars($product['img']) ?>">
          <input type="number" name="quantity" value="1" min="1" max="10" style="width: 60px; margin-right: 10px;">
          <button type="submit" class="btn">Add to Cart</button>
      </form>

      <p id="cartResponse"></p>
    </div>
  </div>

  <footer>
    &copy; <?= date('Y') ?> Grafitoon. All rights reserved.
  </footer>

  <script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "logout.php";
        }
    }

    document.getElementById("addToCartForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
      .then(data => {
    const message = data.trim().toLowerCase();
    if (message === 'added') {
        document.getElementById("cartResponse").textContent = '🛒 Item added to cart!';
    } else {
        document.getElementById("cartResponse").textContent = '❌ Something went wrong: ' + message;
    }
})

        .catch(err => {
            document.getElementById("cartResponse").textContent = '❌ Network error!';
        });
    });
  </script>
</body>
</html>
