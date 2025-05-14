<?php
    session_start();
    require_once 'Database_Connection.php'; // Ensure $conn is established here
    $user_id = $_SESSION['user_id'] ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafitoon - Shop</title>
    <link rel="stylesheet" href="grafitoon_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
       
         body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffefe0;
            color: #222;
        }
        header {
            background-color: #000;
            padding: 20px;
            text-align: center;
        }
        header img {
            width: 160px;
        }
        .hero {
            background-color:rgb(158, 122, 224);
            background-size: cover;
            color: white;
            padding: 30px;
            font-size: 28px;
            font-weight: bold;
        }
        nav {
            background-color: #131313;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 15px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }
        nav a:hover {
            color: #ff6600;
        }
        .shop-banner {
            background-color: #b7ffac;
            text-align: center;
            padding: 60px 20px;
            color: #000;
        }
        .shop-banner h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .shop-banner p {
            font-size: 18px;
            color: #444;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 40px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }
        .product-card .info {
            padding: 15px;
            text-align: center;
        }
        .product-card h3 {
            margin: 10px 0 5px;
            font-size: 20px;
        }
        .product-card p {
            color: #666;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #ff6600;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #cc5200;
        }
        footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 15px;
        }
        .container {
            padding: 40px 20px;
            max-width: 1200px;
            margin: auto;
            text-align: center;
        }

        .filter-buttons {
            margin-bottom: 30px;
        }

        .filter-buttons button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-buttons button:hover,
        .filter-buttons button.active {
            background-color: #cc5200;
        }

      
      
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6600;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: auto; /* Pushes button to bottom */
            cursor: pointer;
            border: none; /* Ensure buttons look like buttons */
        }

        .stock-indicator {
            font-size: 0.9em;
            color: #cc0000;
            margin-bottom: 5px;
        }

        

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .profile-dropdown-content a {
            color: black;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
        /* Added notification style */
        #cart-notification {
            position: fixed;
            top: 80px; /* Below nav */
            right: 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1001;
            display: none; /* Hidden by default */
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="background-gif"></div>

<div id="cart-notification">Item added to cart!</div>

<header>
  <div class="logo">
    <img src="images/grafitoon_logo.png" alt="GrafitoonLogo" width="160">
  </div>
</header>

<nav>
    <a href="Grafitoon_index.php">Home</a>
    <a href="about_us.php">About</a>
    <a href="Grafitoon_shoppingsection.php">Shop</a>
    <a href="Grafitoon_contactus.php">Contact</a>
    <a href="Grafitoon_shoppingcart.php"><i class="fas fa-shopping-cart"></i></a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="profile-dropdown">
            <img src="<?= htmlspecialchars($_SESSION['profile_picture'] ?? 'images/placeholders/default_profile.png') ?>" alt="Profile" class="profile-avatar">
            <div class="profile-dropdown-content">
                <a href="Grafitoon_profile.php"><i class="fas fa-user"></i> My Profile</a>
                <a href="grafitoon_checkout.php"><i class="fas fa-credit-card"></i> Checkout</a>
                <a href="Grafitoon_ordershistory.php"><i class="fas fa-history"></i> Order History</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="Grafitoon_admin.php"><i class="fas fa-tools fa-fw"></i> Admin Dashboard</a>
                <?php endif; ?>
                <a href="#" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
            </div>
        </div>
    <?php else: ?>
        <a href="Grafitoon_login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
    <?php endif; ?>
</nav>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to sign out?")) {
        window.location.href = "logout.php";
    }
}
</script>

<section class="container">
    <h2>Shop Our Cartoon Collection</h2>

    <div class="filter-buttons">
        <button class="active" onclick="filterProducts('all', event)">All</button>
        <button onclick="filterProducts('t-shirts', event)">T-Shirts</button>
        <button onclick="filterProducts('hoodies', event)">Hoodies</button>
        <button onclick="filterProducts('pants', event)">Pants</button>
        <button onclick="filterProducts('accessories', event)">Accessories</button>
    </div>

    <section class="products-grid" id="productGrid">
        <?php
        $products = [
            ["img" => "images/whitetshirt.png", "name" => "Cartoon Tee", "price" => 25, "id" => 1, "category" => "t-shirts"],
            ["img" => "images/hoodie.png", "name" => "Cartoon Hoodie", "price" => 40, "id" => 2, "category" => "hoodies"],
            ["img" => "images/cap.png", "name" => "Cartoon Cap", "price" => 18, "id" => 3, "category" => "accessories"],
            ["img" => "images/sweater.png", "name" => "Cartoon Sweater", "price" => 18, "id" => 4, "category" => "hoodies"],
            ["img" => "images/blueshorts.png", "name" => "Cartoon Shorts", "price" => 19, "id" => 5, "category" => "pants"],
            ["img" => "images/slides.png", "name" => "Cartoon Slides", "price" => 15.45, "id" => 6, "category" => "accessories"]
        ];

        foreach ($products as $product): ?>
            <div class="product-card" data-category="<?= htmlspecialchars($product['category']) ?>">
                <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="info">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p>$<?= htmlspecialchars($product['price']) ?></p>
                    <a href="Grafitoon_product.php?id=<?= $product['id'] ?>" class="btn">Get Now</a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</section>

<footer>
    &copy; <?= date("Y") ?> Grafitoon. All Rights Reserved.
</footer>

<script>
function filterProducts(category, event) {
    const cards = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.filter-buttons button');

    // Toggle active class on buttons
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    cards.forEach(card => {
        const productCategory = card.getAttribute('data-category');
        if (category === 'all' || productCategory === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

</body>
</html>
