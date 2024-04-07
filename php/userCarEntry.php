<?php
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
include('../php/db.php'); // Include your database connection file

$msg = ""; // Variable to store any error or success messages

if(isset($_POST['submit'])) {
    $car_brand = $_POST['car_brand'];
    $car_model = $_POST['car_model'];
    $registration_no = $_POST['registration_no'];
    $car_img = $_POST['car_img'];
    $fee = $_POST['fee'];
    $user_id = $_SESSION['id'];

    $query = "INSERT INTO car_details (user_id, car_brand, car_model, registration_no, car_img, fee) 
              VALUES ('$user_id', '$car_brand', '$car_model', '$registration_no', '$car_img', '$fee')";

    if(mysqli_query($con, $query)) {
        echo "<script>alert('Data inserted successfully')</script>";
    } else {
        echo "<script>alert('There was an error: " . mysqli_error($con) . "')</script>";
    }
}
if(isset($_GET['logout']) && $_GET['logout'] == true){
    session_destroy();
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/renterCarListing.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Car Information Form</title>
    <style>
        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-wrapper {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">Car-Let</div>
            <div class="navbar">
            <a href="carowner_dashboard.php?id=<?php echo $_SESSION['id']; ?>">Home</a>
            <a href="#">My Cars</a>
            <a href="#">Settings</a>
            <a href="userCarEntry.php?logout=true">Logout</a>
            </div>
        </nav>
    </header>

    <div class="form-wrapper">
        <h2>Car Information Form</h2>
        <form action="../php/userCarEntry.php" method="post">
            <label for="car_brand">Brand:</label>
            <input type="text" id="car_brand" name="car_brand" required>

            <label for="car_model">Model:</label>
            <input type="text" id="car_model" name="car_model" required>
            <label for="registration_no">Registration:</label>
            <input type="number" id="registration_no" name="registration_no" required>
            <label for="fee">Fee:</label>
            <input type="number" id="fee" name="fee" required>

            <label for="car_img">Image:</label>
            <input type="file" id="car_img" name="car_img" accept="image/*" required>

            <input type="submit" value="submit" name="submit">
        </form>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <div class="footer-logo">Car Rental</div>
                <p>&copy; 2024 Car Rental</p>
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
</body>

</html>