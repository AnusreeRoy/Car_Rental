<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Renter Profile</title>
<link rel="stylesheet" href="../css/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <h1>Renter Profile</h1>
    <nav>
        <ul>
            <li><a href="renter_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a></li>
            <li><a href="#">My Bookings</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="renter_profile.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="profile-info">
        <h2>Personal Information</h2>
        <div>
            <label>Name:</label>
            <span>Jane Smith</span>
        </div>
        <div>
            <label>Email:</label>
            <span>janesmith@example.com</span>
        </div>
        <div>
            <label>Phone:</label>
            <span>+9876543210</span>
        </div>
    </section>
</main>

<footer>
        <div class="footer-container">
            <div class="footer-info">
                <div class="footer-logo">Car Rental</div>
                <p>&copy; 2024 Car Rental</p>
                <p>Your go-to destination for premium car rentals.</p>
                <p>123 Main Street, Cityville</p>
                <p>Email: info@carrental.com</p>
                <p>Phone: +1 123 456 7890</p>
            </div>
            <div class="social-icons">
                <a href="#" target="_blank"><i class="fa fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </footer>

<script src="script.js"></script>
</body>
</html>
