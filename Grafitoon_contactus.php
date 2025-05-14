<?php
session_start();
$page_title = "Contact Us - Grafitoon";
$company_name = "Grafitoon";
$address = "123 Cartoon Lane, ToonTown, TX 75001";
$email = "support@grafitoon.com";
$phone = "(123) 456-7890";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo $page_title; ?></title>
  <link rel="stylesheet" href="grafitoon_css.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
       * { box-sizing: border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: rgb(84, 78, 121);
      color: #333;
    }

    header {
      background-color:rgb(0, 0, 0);
      color: white;
      padding: 20px 0;
      text-align: center;
    }
.hero {
            background-color:rgb(158, 122, 224);
            background-size: cover;
            color: white;
            padding: 30px;
            font-size: 28px;
            font-weight: bold;
        }
    .contact-container {
      max-width: 1000px;
      margin: 30px auto;
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .contact-info {
      flex: 1;
      min-width: 260px;
    }

    .contact-form {
      flex: 1;
      min-width: 260px;
    }

    .contact-form form label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    .contact-form form input,
    .contact-form form textarea {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: 2px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
      resize: vertical;
    }

    .contact-form form input:focus,
    .contact-form form textarea:focus {
      border-color: #ff6600;
      outline: none;
      box-shadow: 0 0 5px rgba(255, 102, 0, 0.5);
    }

    .contact-form button {
      margin-top: 20px;
      padding: 12px 20px;
      background: linear-gradient(to right, #ff6600, #ff4081);
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    .contact-form button:hover {
      transform: scale(1.03);
      box-shadow: 0 0 10px rgba(255, 102, 0, 0.6);
    }

  

    .success-message {
      display: none;
      background-color: #d4edda;
      padding: 15px;
      border-radius: 10px;
      color: #155724;
      margin-top: 15px;
      text-align: center;
    }
    .profile-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
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
@media (max-width: 768px) {
      .contact-container {
        flex-direction: column;
        padding: 25px;
      }
    footer {
      background-color: #333;
      color: white;
      padding: 10px;
      text-align: center;
      width: 100%;
    }
  </style>
</head>
<body>

<div class="background-gif"></div>

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
        <h1>Contact Us</h1>
        <p>Tell us how we can help</p>
    </section>
<div class="contact-container">
  <div class="contact-info">
    <h2>Contact <?php echo $company_name; ?></h2>
    <p><strong>Address:</strong> <?php echo $address; ?></p>
    <p><strong>Email:</strong> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
    <p><strong>Phone:</strong> <?php echo $phone; ?></p>
    <div class="map">
      <h3>Find Us Here</h3>
      <iframe src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q=<?php echo urlencode($address); ?>" allowfullscreen></iframe>
    </div>
  </div>

  <div class="contact-form">
    <h2>Send Us a Message</h2>
    <p>If you have any questions or feedback, feel free to reach out!</p>
    <form id="contactForm">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email address" required>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required>

      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="6" placeholder="Enter your text..." required></textarea>

      <button type="submit">Send Message</button>
    </form>
    <div id="successMsg" class="success-message">🎉 Message sent! We’ll get back to you soon.</div>
  </div>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. All rights reserved.
</footer>

<script>
  document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();
    document.getElementById("successMsg").style.display = "block";
    this.reset();
  });
</script>

</body>
</html>
<?php
// Close the database connection if it was opened
if (isset($conn)) {
    $conn->close();
}