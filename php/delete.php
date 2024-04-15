<?php
// Include database connection
include('../php/db.php');

// Check if car_id is provided
if(isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Delete car details from the database based on car_id
    $delete_query = "DELETE FROM car_details WHERE id = $car_id";
    $delete_result = mysqli_query($con, $delete_query);

    if($delete_result) {
        // Display success message
        echo "<script>alert('Car deleted successfully.');</script>";
    } else {
        // Display error message
        echo "Failed to delete car.";
    }
}
?>
