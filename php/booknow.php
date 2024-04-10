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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product and Owner Details</title>
    <link rel="stylesheet" href="../css/booknow.css">
</head>
<body>
    <div class="container">
        <div class="product-wrapper">
            <div class="product-card">
            <?php
                include('../php/db.php'); 
                $car_id = $_GET['car_id'];
                $query = "SELECT car_details.*, users.email AS owner_email, users.phone AS owner_phone, users.nid AS owner_nid FROM car_details JOIN users ON car_details.user_id = users.id WHERE car_details.id = $car_id";
                $result = mysqli_query($con, $query);
                
                // Check if the query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch car and car owner data
                    $car = mysqli_fetch_assoc($result);
                } else {
                    // Handle database query error
                    $error_message = "Failed to fetch car details.";
                }
                ?>
                <?php if (isset($car)): ?>
                    <img src="../images/<?php echo $car['car_img']; ?>" alt="<?php echo $car['car_brand']; ?>">
                    <div class="product-details">
                        <h2><?php echo $car['car_brand']; ?></h2>
                        <p><?php echo $car['car_model']; ?></p>
                        <p>Registration: <?php echo $car['registration_number']; ?></p>
                        <p>Fee: <?php echo $car['fee']; ?> </p>
                        <div class="options">
                            <label for="start-date">Start Date:</label>
                            <input type="date" id="start-date" name="start-date">
                            <label for="end-date">End Date:</label>
                            <input type="date" id="end-date" name="end-date">
                        </div>
                        <div class="calculation-details">
                            <button id="calculate-button">Calculate Total Days and Price</button>
                            <p id="total-days"></p>
                            <p id="total-price"></p>
                        </div>
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <p><?php echo $error_message; ?></p>
                <?php else: ?>
                    <p>No car details found.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="owner-wrapper">
            <div class="owner-card">
                <img src="../images/profile.jpg" alt="profile.jpg">
                <div class="owner-details">
                    <p>Email: <?php echo $car['owner_email']; ?></p>
                    <p>Phone: <?php echo $car['owner_phone']; ?></p>
                    <p>NID: <?php echo $car['owner_nid']; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="confirmation-button">
        <button id="confirm-button">Confirm Booking</button>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const calculateButton = document.getElementById("calculate-button");
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    const totalDaysParagraph = document.getElementById("total-days");
    const totalPriceParagraph = document.getElementById("total-price");

    calculateButton.addEventListener("click", function() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const oneDay = 24 * 60 * 60 * 1000; 

        if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
            const totalDays = Math.round(Math.abs((endDate - startDate) / oneDay));
            
            // Fetch the fee of the selected car from the server
            const carId = <?php echo $car['id']; ?>;// Assuming you have the car ID available in the PHP variable $car['id']
            fetch(`getCarFee.php?car_id=${carId}`)
                .then(response => response.json())
                .then(data => {
                    const totalPrice = totalDays * data.fee;
                    totalDaysParagraph.textContent = `Total Days: ${totalDays}`;
                    totalPriceParagraph.textContent = `Total Price: ${totalPrice}tk`;
                })
                .catch(error => {
                    console.error('Error fetching car fee:', error);
                });
        } else {
            totalDaysParagraph.textContent = "Please select valid dates";
            totalPriceParagraph.textContent = "";
        }
    });
});

    </script>
</body>
</html>
