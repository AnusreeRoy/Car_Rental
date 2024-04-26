<?php
session_start();
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
include('../php/db.php');

// Get the current date
$currentDate = date('Y-m-d');

// Retrieve bookings where the returndate has not passed
$query = "SELECT booking_details.car_id FROM booking_details
          INNER JOIN car_details ON booking_details.car_id = car_details.id
          WHERE '$currentDate' > booking_details.returndate";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Update the corresponding car's book_status to 'available'
        $carId = $row['car_id'];
        $updateQuery = "UPDATE car_details SET book_status = 'available' WHERE id = '$carId'";
        mysqli_query($con, $updateQuery);
    }
} else {
    // Handle error if query fails
    echo "Failed to retrieve expired bookings.";
}

// Close the database connection
mysqli_close($con);
?>
