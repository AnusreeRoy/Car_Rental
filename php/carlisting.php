<?php
session_start();
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Listing</title>
    <link rel="stylesheet" href="../css/carlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <h1>Car Owner Dashboard</h1>
    <nav>
        <ul>
            <li><a href="carowner_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a></li>
            <li><a href="carowner_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="carlisting.php?id=<?php echo $_SESSION['id']; ?>">Car Listings</a></li>
            <li><a href="userCarEntry.php?id=<?php echo $_SESSION['id']; ?>">Add Car</a></li>
            <li><a href="carowner_dashboard.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>

    <div class="container">
    <?php
include('../php/db.php'); // Include your database connection file

// Fetch car details from the database
$query = "SELECT car_brand, car_model, car_img, book_status, fee FROM car_details";
$result = mysqli_query($con, $query);

// Check if there are any errors in the query execution
if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Loop through each row to display car details
    while ($row = mysqli_fetch_assoc($result)) {
        

        echo '<div class="product-item">';
        echo '<img src="../images/' . $row['car_img'] . '" alt="Image">';
        echo '<div class="Car-details">';
        echo '<h3>' . $row['car_model'] . '</h3>';
        echo '<p>Brand: ' . $row['car_brand'] . '</p>';
        echo '<p>Fee: ৳' . $row['fee'] . '</p>';
        echo '<p>Status: ' . $row['book_status'] . '</p>';
        echo '<div class="book-now-box">';
        echo '<a href="booknow.html" class="book-now-button">Book Now</a>';
        echo '</div></div></div>';
    }
} else {
    // If no cars found in the database
    echo '<p>No cars available</p>';
}

// Close the database connection
mysqli_close($con);
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
