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
<title>Car Owner Dashboard</title>
<link rel="stylesheet" href="../css/renter_dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <h1>Car Owner Dashboard</h1>
    <nav>
        <ul>
            <li><a href="carowner_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="carlisting.php?id=<?php echo $_SESSION['id']; ?>">Car Listings</a></li>
            <li><a href="userCarEntry.php?id=<?php echo $_SESSION['id']; ?>">Add Car</a></li>
            <li><a href="carowner_dashboard.php?logout=true">Logout</a></li>
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
        <?php
        include('../php/db.php'); 
        $query = "SELECT id, car_brand, car_model, car_img, book_status, fee FROM car_details";
        $result = mysqli_query($con, $query);
        
        // Check if there are any errors in the query execution
        if (!$result) {
            die("Database query failed: " . mysqli_error($con));
        }
        
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row to display car details
            while ($row = mysqli_fetch_assoc($result)) {
                $carId = trim($row['id']);  
       
            echo'<div class="car">
            <img src="../images/' . $row['car_img'] . '" alt="Image">
            <h3>' . $row['car_model'] . '</h3>
            <p>Brand: ' . $row['car_brand'] . '</p>
            <p>Fee: ৳' . $row['fee'] . '</p>
            <p><b>Availability: ' . $row['book_status'] . '</b></p>
            <form id="book-now-form" action="booknow.php" method="GET">
            <input type="hidden" name="car_id" value="' . $carId . '">
           <button type="submit">Book Now</button>
           </form>
           </div>';
            }
        }else{
            echo '<p>No cars available</p>';
        }
        mysqli_close($con);
        ?>

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
</body>
</html>
