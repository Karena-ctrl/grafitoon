<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Grafitoon</title>
    <link rel="stylesheet" href="grafitoon_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(102, 59, 112);
            text-align: center;
        }
        header {
            background-color: rgb(0, 0, 0);
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5; /* Adjust opacity as needed */
        }
        .logo {
            font-size: 36px;
            font-weight: bold;
        }

        .grafi {
            color: white;
        }

        .toon {
            color: orange;
        }

            header {
    background-color:rgb(0, 0, 0);
    color: white;
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
}
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            vertical-align: middle;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #222;
            min-width: 180px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 1000;
            border-radius: 10px;
            overflow: hidden;
        }

        .profile-dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background 0.3s ease;
        }

        .profile-dropdown-content a:hover {
            background-color: #333;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }
.hero {
            background-color:rgb(158, 122, 224);
            background-size: cover;
            color: white;
            padding: 30px;
            font-size: 28px;
            font-weight: bold;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .feature-card {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            max-width: 300px; /* Adjusted width for better layout */
        }
        .team-card img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
        }
     header {
    background-color:rgb(0, 0, 0);
    color: white;
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
}
        footer {
            background-color: #000;
            color: #888;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        #welcome-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: orange;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            z-index: 9999;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
    <div id="welcome-popup">
        Signed in successfully, welcome back <?= htmlspecialchars($_SESSION['username']) ?>!
    </div>
    <script>
        setTimeout(() => {
            const popup = document.getElementById('welcome-popup');
            if (popup) popup.style.display = 'none';
        }, 4000);
    </script>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>

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

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to sign out?")) {
        window.location.href = "logout.php";
    }
}
</script>

<section class="hero">
    <h1>About Grafitoon</h1>
    <p>Streetwear meets Saturday morning vibes — bold, animated, unforgettable.</p>
</section>

  <section class="hero">
        <h1>Who We Are</h1>
        <p>Urban vibes meet animated expression.</p>
    </section>

    <section class="features">
        <div class="feature-card">
            <h2>Our Mission</h2>
            <p>Grafitoon is more than a store — it's a culture. We blend graffiti art and cartoon influence into every piece, bringing bold, unique styles to the streets.</p>
        </div>
        <div class="feature-card">
            <h2>Why Grafitoon?</h2>
            <p>Whether you’re looking for statement outfits or accessories that stand out, we offer something fresh and expressive for all ages.</p>
        </div>
        <div class="feature-card">
            <h2>The Project</h2>
            <p>Grafitoon is a creative group project developed by passionate college students. Every piece of this site is student-built.</p>
        </div>
    </section>

    <!-- Meet the Team Section -->
    <section class="features">
        <div class="feature-card team-card">
            <img src="images/team1.jpg" alt="Juliann Wilson">
            <h2>Juliann Wilson</h2>
            <p>Juliann leads the creative minds behind Grafitoon’s designs. With a background in animation and graphic design, she brings ideas to life by mixing Saturday morning cartoons with modern-day streetwear. From sketch to stitch, every piece tells a unique story.</p>
        </div>
        <div class="feature-card team-card">
            <img src="images/team2.jpg" alt="Karena Galloway">
            <h2>Karena Galloway</h2>
            <p>Founder of Grafitoon. Karena combines her love of fashion and animation to build a brand that celebrates individuality. With over 8 years in eCommerce, she’s driven to make custom fashion accessible, expressive, and personal.</p>
        </div>
        <div class="feature-card team-card">
            <img src="images/team3.jpg" alt="Ira Thompson">
            <h2>Ira Thompson</h2>
            <p>A passionate designer with an eye for graphics and video editing. Ira blends his love for aviation tech and sports with creative flair, bringing innovation to every project he touches.</p>
        </div>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Grafitoon. All Rights Reserved.
    </footer>
</body>
</html>
