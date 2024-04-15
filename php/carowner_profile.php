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
<title>Car Owner Profile</title>
<link rel="stylesheet" href="../css/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <h1>Car Owner Profile</h1>
    <nav>
        <ul>
            <li><a href="carowner_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a></li>
            <li><a href="carlisting.php?id=<?php echo $_SESSION['id']; ?>">Car Listing</a></li>
            <li><a href="userCarEntry.php?id=<?php echo $_SESSION['id']; ?>">Add Car</a></li>
            <li><a href="carowner_profile.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>
<section class="profile">
<div class="profile-container">
        <h1>User Profile</h1>
        <img src="../images/profile.jpg" height="300px" width="300px">
        <?php 
        include('../php/db.php'); 
        $query = "SELECT * FROM users WHERE id = {$_GET['id']}";
$result = mysqli_query($con, $query);

// Check if the query was successful
if ($result) {
    // Fetch user data
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle database query error
    $error_message = "Failed to fetch user information.";
}
        if (isset($user)): ?>
            <div class="user-info">
                <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>NID:</strong> <?php echo $user['nid']; ?></p>
                <!-- Add more user information fields as needed -->
            </div>
        <?php elseif (isset($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php else: ?>
            <p>No user information found.</p>
        <?php endif; ?>
    </div>
        </section>
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
</body>
</html>
