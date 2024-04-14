<?php
// Connect to the database
include('../php/db.php');

// Get the current date
$currentDate = date('Y-m-d');

// Retrieve bookings where the returndate has passed
$query = "SELECT * FROM booking_details WHERE returndate < '$currentDate'";
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
