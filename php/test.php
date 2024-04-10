<?php
include('db.php'); // Include your database connection file

// Check if the car_id is provided in the URL
if(isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Fetch car details along with the car owner information
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
} else {
    // Redirect to another page if car_id is not provided
    header("Location: some_other_page.php");
    exit(); // Stop further execution of the script
}
?>


<div class="owner-details">
    <h2>Car Owner</h2>
    <p>Name: <?php echo $car['owner_name']; ?></p>
    <p>Email: <?php echo $car['owner_email']; ?></p>
    <p>Phone: <?php echo $car['owner_phone']; ?></p>
    <p>NID: <?php echo $car['owner_nid']; ?></p>
</div>
