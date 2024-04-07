<?php
session_start(); // Start session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
// Now continue with dashboard content...
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Renter Dashboard</title>
<link rel="stylesheet" href="../css/renter_dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <h1>Renter Dashboard</h1>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="renter_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="#">Bookings</a></li>
            <li><a href="renter_dashboard.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <section id="search">
        <h2>Search for Cars</h2>
        <form>
            <input type="text" id="searchInput" placeholder="Search for cars...">
            <button type="submit">Search</button>
        </form>
    </section>

    <section id="carList">
        <h2>Available Cars</h2>
        <div class="car">
            <img src="../images/allion2006model.jpg" alt="Car Image">
            <h3>Toyota Corolla</h3>
            <p>Registration No: ABC123</p>
            <p>Fee: $50/day</p>
            <button>Book Now</button>
        </div>
        <div class="car">
            <img src="../images/download2.jpg" alt="Car Image">
            <h3>Honda Civic</h3>
            <p>Registration No: XYZ456</p>
            <p>Fee: $60/day</p>
            <button>Book Now</button>
        </div>
        <div class="car">
            <img src="../images/download2.jpg" alt="Car Image">
            <h3>Honda Civic</h3>
            <p>Registration No: XYZ456</p>
            <p>Fee: $60/day</p>
            <button>Book Now</button>
        </div>
        <!-- More cars can be added dynamically here -->
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
