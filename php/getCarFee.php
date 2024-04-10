<?php
// Include your database connection file
include('../php/db.php');

// Check if car_id parameter is provided in the request
if(isset($_GET['car_id'])) {
    // Sanitize the input to prevent SQL injection
    $car_id = mysqli_real_escape_string($con, $_GET['car_id']);

    // Query to fetch the fee of the car from the database
    $query = "SELECT fee FROM car_details WHERE id = $car_id";

    // Execute the query
    $result = mysqli_query($con, $query);

    if($result) {
        // Check if a row is returned
        if(mysqli_num_rows($result) == 1) {
            // Fetch the fee value
            $row = mysqli_fetch_assoc($result);
            $fee = $row['fee'];

            // Return the fee value as JSON response
            echo json_encode(array('fee' => $fee));
        } else {
            // Car with the provided ID not found
            echo json_encode(array('error' => 'Car not found'));
        }
    } else {
        // Database query error
        echo json_encode(array('error' => 'Database error'));
    }
} else {
    // Car ID parameter is missing
    echo json_encode(array('error' => 'Car ID parameter missing'));
}
?>
