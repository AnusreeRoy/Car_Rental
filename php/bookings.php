<?php
session_start(); // Start session
$user_id = $_SESSION['id'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="../css/bookings.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <h1>CarLet</h1>
    <nav>
        <ul> 
        <li><a href="renter_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="renter_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a></li>
            <li><a href="renter_dashboard.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php
    include('../php/db.php'); 

    // Query to retrieve booking details for the renter
    $query_bookings = "SELECT * FROM booking_details WHERE user_id = $user_id";
    $result_bookings = mysqli_query($con, $query_bookings);

    // Check if bookings were found
    if ($result_bookings && mysqli_num_rows($result_bookings) > 0) {
        // Loop through each booking
        while ($booking = mysqli_fetch_assoc($result_bookings)) {
            // Retrieve car details for the current booking
            $car_id = $booking['car_id'];
            $query_car_details = "SELECT * FROM car_details WHERE id = $car_id";
            $result_car_details = mysqli_query($con, $query_car_details);

            // Check if car details were found
            if ($result_car_details && mysqli_num_rows($result_car_details) > 0) {
                $car = mysqli_fetch_assoc($result_car_details);
                // Display booking and car details
                echo '<div class="car-item">';
                echo '<img src="../images/' . $car['car_img'] . '" alt="Car Image">';
                echo '<div class="car-details">';
                echo "<p>Car: " . $car['car_brand'] . " " . $car['car_model'] . "</p>";
                echo "<p>Pickup Date: " . $booking['pickupdate'] . "</p>";
                echo "<p>Return Date: " . $booking['returndate'] . "</p>";
                echo "<p>Total Fee: " . $booking['totalfee'] . "</p>";
                echo "</div></div>";
            } else {
                echo "Error: Unable to fetch car details for booking ID " . $booking['id'] . "<br>";
            }
        }
    } else {
        echo "<p>No bookings found.</p>";
    }
    ?>
</div>

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

