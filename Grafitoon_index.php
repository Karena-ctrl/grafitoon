<?php
session_start();
require 'Database_Connection.php'; // Make sure this file connects using $conn
$user_id = $_SESSION['user_id'] ?? 1;

// This could later be replaced by DB queries
$products = [
    ["id" => 1, "img" => "images/whitetshirt.png", "name" => "Custom Tee", "price" => "25.00"],
    ["id" => 2, "img" => "images/hoodie.png", "name" => "Custom Hoodie", "price" => "40.00"],
    ["id" => 3, "img" => "images/cap.png", "name" => "Custom Cap", "price" => "18.00"],
    ["id" => 4, "img" => "images/slides.png", "name" => "Custom Slides", "price" => "15.45"],
    ["id" => 5, "img" => "images/blueshorts.png", "name" => "Custom Shorts", "price" => "19.00"],
    ["id" => 6, "img" => "images/sweater.png", "name" => "Custom Sweater", "price" => "18.00"]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafitoon - Home</title>
    <link rel="stylesheet" href="grafitoon_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: orange;
            color: #333;
        }
        header {
            background: #000;
            color: white;
            text-align: center;
            padding: 20px;
        }
        nav {
            background-color: #131313;
            text-align: center;
            padding: 10px 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        nav a:hover {
            color: #ff6600;
        }
        .profile-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    vertical-align: middle;
    cursor: pointer;
}

.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #1a1a1a;
    min-width: 200px;
    z-index: 1000;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.profile-dropdown:hover .profile-dropdown-content {
    display: block;
}

.profile-dropdown-content a {
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.profile-dropdown-content a:hover {
    background-color: #333;
}
        .hero {
            background-image: url('background-gif.GIF');
            color: white;
            text-align: center;
            padding: 185px 20px;
        }
        .swiper {
            width: 100%;
            padding: 40px 0;
        }
        .swiper-slide {
            background: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .swiper-slide img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .swiper-button-prev,
.swiper-button-next {
    color: #ff5e00;
    background: #fff;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.swiper-button-prev::after,
.swiper-button-next::after {
    font-size: 20px;
    font-weight: bold;
}

        .product-info {
            padding: 10px;
        }
        .btn {
            background-color: #ff5e00;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            display: inline-block;
            margin-top: 10px;
        }
        footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 15px;
        }
    </style>
</head>
<script>
function confirmLogout() {
    if (confirm("Are you sure you want to sign out?")) {
        window.location.href = 'logout.php';
    }
}
</script>

<body>

<?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
    <div id="welcome-popup" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #ff6600;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        font-weight: bold;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
        z-index: 1000;
    ">
        Signed in successfully, welcome back <?= htmlspecialchars($_SESSION['username']) ?>!
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('welcome-popup').style.display = 'none';
        }, 5000);
    </script>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>

<div class="background-gif"></div>

<header>
  <div class="logo">
    <img src="images/grafitoon_logo.png" alt="GrafitoonLogo" width="160">
  </div>
</header>

<nav>
    <a href="grafitoon_index.php">Home</a>
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

<section class="hero">
    <h1>Welcome to Grafitoon</h1>
    <p>Where Urban Streetwear Meets Cartoon Vibes!</p>
    <a href="Grafitoon_shoppingsection.php" class="btn">Shop Now</a>
</section>

<div style="text-align: center; margin-top: 40px;">
<h3>Scan to Visit GrafiToon</h3>
    <a href="index.php">
        <img src="images/QR_code.png"  alt="QR Code to GrafiToon" style="width: 150px; height: 150px;">
    </a>
</div>



<!-- Swiper Carousel -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php foreach ($products as $product): ?>
        <div class="swiper-slide">
            <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
            <div class="product-info">
                <h3><?= $product['name'] ?></h3>
                <p>$<?= $product['price'] ?></p>
                <a href="Grafitoon_product.php?id=<?= $product['id'] ?>" class="btn">View</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Navigation Arrows -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<footer>
    &copy; 2025 Grafitoon. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
    },
});
</script>

</body>
</html>
