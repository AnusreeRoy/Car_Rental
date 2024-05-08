<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Car-Let:Home Page</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Car-Let</div>
            <div class="navbar">
                <a href="aboutus.php">About Us</a>
                <a href="#">Contact</a>
                <a href="../php/signup.php">Login/Signup</a>
            </div>
        </nav>
    </header>
    <section class="hero">
    <img src="../images/carpic.jpeg">
        <div class="search-container">
        <div class="search-bar">
                <input type="text" id="searchCars" placeholder="Search Cars" onkeyup="showResult(this.value)">
                <button onclick="searchCars()">Search</button>
            </div>
            <div id="livesearch"></div>
        </div>
</section>

        <section class="featured-class">
        <div class="car-container">
            <?php
            // Include database connection
            include('../php/db.php');

            // Query to fetch all cars from the car_details table
            $query = "SELECT * FROM car_details";
            $result = mysqli_query($con, $query);

            // Check if there are any cars
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display car details
                    echo '<div class="car">';
                    echo '<img src="../images/' . $row['car_img'] . '" alt="' . $row['car_brand'] . '">';
                    echo '<h2>' . $row['car_brand'] . '</h2>';
                    echo '<p>' . $row['car_model'] . '</p>';
                    echo '<p>Registration: ' . $row['registration_no'] . '</p>';
                    echo '<p>Fee: ' . $row['fee'] . '</p>';
                    echo '<p><b>Availability: ' . $row['book_status'] . '</b></p>';
                    echo '<button class="bookButton"><a href="login.php" class="confirmation-button">Book Now</a></button>';
                    echo '</div>';
                }
            } else {
                // No cars found
                echo '<p>No cars available.</p>';
            }
            ?>
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

   
    <script>
        function showResult(str) {
            if (str.length == 0) {
                document.getElementById("livesearch").innerHTML = "";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "livesearch.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
</body>
</html>
