<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    session_destroy();
    header("Location: home.php");
    exit();
}
include('../php/db.php');
if (isset($_POST['confirm_booking'])) {
    // Retrieve form data
    $user_id = $_SESSION['id'];
    $pickupdate = $_POST['pickupdate'];
    $returndate = $_POST['returndate'];

    if (empty($pickupdate) || empty($returndate)) {
        echo "<script>alert('Please select both start and end dates.'); window.history.back();</script>";
        exit();
    }

    // Check if 'car_id' is provided in the URL
    if (isset($_POST['car_id'])) {
        $car_id = $_POST['car_id'];

        // Fetch the fee of the selected car from the server
        $query_get_fee = "SELECT fee FROM car_details WHERE id = $car_id";
        $result_get_fee = mysqli_query($con, $query_get_fee);

        $query_check_status = "SELECT book_status FROM car_details WHERE id = '$car_id'";
        $result_check_status = mysqli_query($con, $query_check_status);



        // Check if the query was successful
        if ($result_get_fee && mysqli_num_rows($result_get_fee) > 0) {
            $car = mysqli_fetch_assoc($result_get_fee);
            $fee = $car['fee'];

            // Calculate total fee based on the selected dates
            $pickupdate = new DateTime($pickupdate);
            $returndate = new DateTime($returndate);
            $interval = $pickupdate->diff($returndate);
            $total_days = $interval->days;
            $totalfee = $total_days * $fee;

            // Format DateTime objects as strings
            $pickupdate_str = $pickupdate->format('Y-m-d');
            $returndate_str = $returndate->format('Y-m-d');

            // Check for overlapping bookings
            $query_check_overlap = "SELECT * FROM booking_details WHERE car_id = '$car_id' 
                                    AND (pickupdate BETWEEN '$pickupdate_str' AND '$returndate_str'
                                    OR returndate BETWEEN '$pickupdate_str' AND '$returndate_str')";
            $result_check_overlap = mysqli_query($con, $query_check_overlap);

            // If there are overlapping bookings, display an error message
            if ($result_check_overlap && mysqli_num_rows($result_check_overlap) > 0) {
                echo "<script>alert('This car is already booked for the selected dates. Please choose different dates.');</script>";
                exit();
            } else {
                // No overlapping bookings, proceed with confirming the booking

                // Insert booking details into the booking_details table
                $query_insert_booking = "INSERT INTO booking_details (car_id, user_id, pickupdate, returndate, totalfee) 
                                         VALUES ('$car_id', '$user_id', '$pickupdate_str', '$returndate_str', '$totalfee')";
                $result_insert_booking = mysqli_query($con, $query_insert_booking);

                // Update book_status in car_details table to 'booked'
                $query_update_car = "UPDATE car_details SET book_status = 'booked' WHERE id = '$car_id'";
                $result_update_car = mysqli_query($con, $query_update_car);

                if ($result_insert_booking && $result_update_car) {
                    echo "<script>alert('Booking confirmed successfully.');</script>";
                    // Redirect to the renter dashboard page after a short delay
                    echo "<script>setTimeout(function() {
                        window.location.href = 'payment.php?id=" . $_SESSION['id'] . "';
                    }, 1000);</script>";
                    exit();
                } else {

                    echo "<script>alert('Failed to confirm booking. Please try again.');</script>";
                }
            }
        } else {

            echo "<script>alert('Failed to fetch car.');</script>";
        }
    } else {

        echo "<script>alert('CarID not given.');</script>";
    }
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
                // include('../php/db.php'); 
                $car_id = $_GET['car_id'];
                $query = "SELECT car_details.*, users.email AS owner_email, users.phone AS owner_phone, users.nid AS owner_nid FROM car_details JOIN users ON car_details.user_id = users.id WHERE car_details.id = $car_id";
                $result = mysqli_query($con, $query);

                // Check if the query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch car and car owner data
                    $car = mysqli_fetch_assoc($result);
                } else {
                    // Handle database query error
                    echo "<script>alert('Failed to fetch car.');</script>";
                }
                ?>
                <?php if (isset($car)) : ?>
                    <img src="../images/<?php echo $car['car_img']; ?>" alt="<?php echo $car['car_brand']; ?>">
                    <div class="product-details">
                        <h2><?php echo $car['car_brand']; ?></h2>
                        <p><?php echo $car['car_model']; ?></p>
                        <p>Registration: <?php echo $car['registration_no']; ?></p>
                        <p>Fee: <?php echo $car['fee']; ?> </p>
                        <form id="book-now-form" action="../php/booknow.php" method="POST">
                            <input type="hidden" name="car_id" value="<?php echo isset($_GET['car_id']) ? $_GET['car_id'] : ''; ?>">
                            <div class="options">
                                <label for="start-date">Start Date:</label>
                                <input type="date" id="pickupdate" name="pickupdate" min="<?php echo date('Y-m-d'); ?>">
                                <label for="end-date">End Date:</label>
                                <input type="date" id="returndate" name="returndate" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="calculation-details">
                                <!-- <button id="calculate-button">Calculate Total Days and Price</button> -->
                                <p id="total-days"></p>
                                <p id="totalfee" name="totalfee"></p>
                            </div>
                            <div class="confirmation-button">
                                <button id="confirm-button" type="submit" name='confirm_booking'>Confirm Booking</button>
                            </div>
                        </form>
                    </div>
                <?php elseif (isset($error_message)) : ?>
                    <p><?php echo $error_message; ?></p>
                <?php else : ?>
                    <p>No car details found.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="owner-wrapper">
            <div class="owner-card">
                <img src="../images/profile.jpg" alt="profile.jpg">
                <div class="owner-details">
                    <h3>Car Owner Details</h3>
                    <p>Email: <?php echo $car['owner_email']; ?></p>
                    <p>Phone: <?php echo $car['owner_phone']; ?></p>
                    <p>NID: <?php echo $car['owner_nid']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const startDateInput = document.getElementById("pickupdate");
            const endDateInput = document.getElementById("returndate");
            const totalDaysParagraph = document.getElementById("total-days");
            const totalPriceParagraph = document.getElementById("totalfee");
            const errorMessage = document.getElementById("error-message");
            const confirmButton = document.getElementById("confirm-button");

            function calculateTotal() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const oneDay = 24 * 60 * 60 * 1000;

                if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime()) && endDate >= startDate) {
                    const totalDays = Math.round(Math.abs((endDate - startDate) / oneDay));

                    const carId = <?php echo $car['id']; ?>;
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
            }

            startDateInput.addEventListener("change", calculateTotal);
            endDateInput.addEventListener("change", calculateTotal);

            confirmButton.addEventListener("click", function(event) {
                if (!startDateInput.value || !endDateInput.value) {
                    errorMessage.style.display = "block";
                    event.preventDefault();
                } else {
                    errorMessage.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>