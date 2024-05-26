<?php
include('../php/db.php');

// Get the current date
$currentDate = date('Y-m-d');
echo "Current Date: " . $currentDate . "<br>";

// Retrieve bookings where the returndate has not passed
$query = "SELECT booking_details.car_id FROM booking_details
          INNER JOIN car_details ON booking_details.car_id = car_details.id
          WHERE '$currentDate' > booking_details.returndate";
echo "Query: " . $query . "<br>";

$result = mysqli_query($con, $query);

if ($result) {
    echo "Query executed successfully.<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Output the car ID to verify it's being retrieved correctly
        echo "Car ID: " . $row['car_id'] . "<br>";
        // Update the corresponding car's book_status to 'available'
        $carId = $row['car_id'];
        $updateQuery = "UPDATE car_details SET book_status = 'available' WHERE id = '$carId'";
        // Output the update query for debugging
        echo "Update Query: " . $updateQuery . "<br>";
        // Execute the update query
        if (mysqli_query($con, $updateQuery)) {
            echo "Book status updated successfully for car ID: " . $carId . "<br>";
            // Update the corresponding booking's status to 'rejected'
            $rejectQuery = "UPDATE booking_details SET status = 'rejected' WHERE car_id = '$carId' AND status = 'pending'";
            // Output the reject query for debugging
            echo "Reject Query: " . $rejectQuery . "<br>";
            // Execute the reject query
            if (mysqli_query($con, $rejectQuery)) {
                echo "Booking status updated to 'rejected' for car ID: " . $carId . "<br>";
            } else {
                echo "Error updating booking status to 'rejected' for car ID: " . $carId . "<br>";
            }
        } else {
            echo "Error updating book status for car ID: " . $carId . "<br>";
        }
    }
} else {
  
    echo "Failed to retrieve expired bookings: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
