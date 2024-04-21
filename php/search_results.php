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
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/renter_dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <h1>Renter Dashboard</h1>
    <nav>
        <ul>
            <li><a href="renter_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="bookings.php?id=<?php echo $_SESSION['id']; ?>">Bookings</a></li>
            <li><a href="renter_dashboard.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>
<?php
// Include database connection
include('../php/db.php');

// Check if search query is provided
if(isset($_GET['query']) && !empty($_GET['query'])) {
    // Sanitize the search query to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($con, $_GET['query']);
    // Construct the SQL query to search for cars
    $sql = "SELECT * FROM car_details WHERE car_brand LIKE '%$searchQuery%' OR car_model LIKE '%$searchQuery%'";
    
    // Execute the query
    $result = mysqli_query($con, $sql);
    
    // Check if any cars match the search query
    if($result) {
        if(mysqli_num_rows($result) > 0) {
            // Display the matching cars
            while($row = mysqli_fetch_assoc($result)) {
                echo'
                <div class="car">
            <img src="../images/' . $row['car_img'] . '" alt="Image">
            <h3>' . $row['car_model'] . '</h3>
            <p>Brand: ' . $row['car_brand'] . '</p>
            <p>Fee: ৳' . $row['fee'] . '</p>
            <p><b>Availability: ' . $row['book_status'] . '</b></p>
            <form id="book-now-form" action="booknow.php" method="GET">
            <input type="hidden" name="car_id" value="' . $carId . '">
           <button type="submit">Book Now</button>
           </form>
           </div>'
           ;
            }
        } else {
            // If no cars match the search query
            echo "No cars found matching the search query.";
        }
    } else {
        // Handle query execution error
        echo "Error executing database query: " . mysqli_error($con);
    }
} else {
    // If search query is not provided
    echo "Please provide a search query.";
}

// Close the database connection
mysqli_close($con);
?>

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



