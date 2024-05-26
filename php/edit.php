<?php
session_start();
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
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
if(isset($_POST['edit_car'])) {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car Details</title>
    <link rel="stylesheet" href="../css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<header>
    <h1>Car Owner Dashboard</h1>
    <nav>
        <ul>
            <li><a href="carowner_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a></li>
            <li><a href="carowner_profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="carlisting.php?id=<?php echo $_SESSION['id']; ?>">Car Listings</a></li>
            <li><a href="userCarEntry.php?id=<?php echo $_SESSION['id']; ?>">Add Car</a></li>
            <li><a href="carowner_dashboard.php?logout=true">Logout</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="container">
        <h1>Edit Car Details</h1>
        <?php
        include('../php/db.php'); 
        // Check if car ID is provided
        if(isset($_GET['car_id'])) {
            $car_id = $_GET['car_id'];

            // Fetch car details from the database
            $query = "SELECT * FROM car_details WHERE id = $car_id";
            $result = mysqli_query($con, $query);

            // Check if car exists
            if(mysqli_num_rows($result) > 0) {
                $car = mysqli_fetch_assoc($result);
        ?>
            <form method="POST" action="">
        <input type="text" name="car_brand" value="<?php echo $car['car_brand']; ?>" placeholder="Car Brand" required><br>
        <input type="text" name="car_model" value="<?php echo $car['car_model']; ?>" placeholder="Car Model" required><br>
        <input type="text" name="car_img" value="<?php echo $car['car_img']; ?>" placeholder="Car Image URL" required><br>
        <input type="number" name="fee" value="<?php echo $car['fee']; ?>" placeholder="Fee" required><br>
        <select name="book_status">
            <option value="available" <?php if($car['book_status'] == 'available') echo 'selected'; ?>>Available</option>
            <option value="booked" <?php if($car['book_status'] == 'booked') echo 'selected'; ?>>Booked</option>
        </select><br>
        <input type="submit" name="edit_car" value="Edit Car Details" class="button">
    </form>
        <?php
            } else {
                echo "<p>Car not found.</p>";
            }
        } else {
            echo "<p>Car ID not provided.</p>";
        }
        ?>
    </div>
    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <div class="footer-logo">CarLet</div>
                <p>&copy; 2024 CarLet</p>
                <p>Your go-to destination for premium car rentals.</p>
                <p>123 Main Street, Cityville</p>
                <p>Email: info@carrental.com</p>
                <p>Phone: +1 123 456 7890</p>
            </div>
            <div class="social-icons">
                <a href="#" target="_blank"><i class="fa fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
            
            </div>
        </div>
    </footer>

    <script>
        function deleteCar(carId) {
            if(confirm("Are you sure you want to delete this car?")) {
                window.location.href = "delete_car.php?car_id=" + carId;
            }
        }
        function UpdateCar(carId) {
            if(confirm("Are you sure you want to update this car?")) {
                window.location.href = "updateCar.php?car_id=" + carId;
            }
        }
    </script>
</body>
</html>
