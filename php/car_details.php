<?php
// Include database connection
include('../php/db.php');

// Check if a car ID is provided in the query string
if(isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Query to fetch car details based on the provided car ID
    $query = "SELECT * FROM car_details WHERE id = $car_id";
    $result = mysqli_query($con, $query);

    // Check if the query was successful and if a car was found
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch car details
        $car = mysqli_fetch_assoc($result);
    } else {
        // Handle error if car details are not found
        echo "Car details not found.";
        exit(); 
    }
} else {
    
    echo "Car ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['car_model']; ?> Details</title>
    <link rel="stylesheet" href="../css/car_details.css">
</head>
<body>
    <div class="container">
        <div class="car-details">
            <h2><?php echo $car['car_model']; ?></h2>
            <img src="../images/<?php echo $car['car_img']; ?>" alt="<?php echo $car['car_model']; ?>">
            <p><strong>Brand:</strong> <?php echo $car['car_brand']; ?></p>
            <p><strong>Registration:</strong> <?php echo $car['registration_no']; ?></p>
            <p><strong>Status:</strong> <?php echo $car['book_status']; ?></p>
            <p><strong>Fee:</strong> <?php echo $car['fee']; ?></p>
        </div>
    </div>
</body>
</html>
