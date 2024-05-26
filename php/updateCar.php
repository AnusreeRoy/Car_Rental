<?php
session_start();
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
// Include database connection
include('../php/db.php');
// Check if car_id is provided
if(isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Fetch car details from the database based on car_id
    $query = "SELECT * FROM car_details WHERE id = $car_id";
    $result = mysqli_query($con, $query);

    // Check if car details are found
    if(mysqli_num_rows($result) > 0) {
        // Fetch car details
        $car = mysqli_fetch_assoc($result);
    } else {
        // Redirect or display error message if car details are not found
        echo "Car details not found.";
        exit();
    }
} else {
    // Redirect or display error message if car_id is not provided
    echo "Car ID is not provided.";
    exit();
}

// Check if form is submitted for editing
if(isset($_POST['update_car'])) {
    // Retrieve form data
    $car_brand = $_POST['car_brand'];
    $car_model = $_POST['car_model'];
    $car_img = $_POST['car_img'];
    $fee = $_POST['fee'];
    $book_status = $_POST['book_status'];

    // Update car details in the database
    $update_query = "UPDATE car_details SET car_brand = '$car_brand', car_model = '$car_model', car_img = '$car_img', fee = '$fee', book_status = '$book_status' WHERE id = $car_id";
    $update_result = mysqli_query($con, $update_query);

    if($update_result) {
       
        echo "<script>alert('Car details updated successfully.');</script>";
    } else {
      
        echo "Failed to update car details.";
    }
}
?>