<?php
include('../php/db.php');
$msg = "";

if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $registration_no = $_POST['registration_no'];
    $fee = $_POST['fee'];
    $user_id = 1; 

    $targetDir = "uploads/"; 
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

   
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $msg = "File is not an image.";
            $uploadOk = 0;
        }
    }


    if (file_exists($targetFile)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }

  
    if ($_FILES["image"]["size"] > 500000) {
        $msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    
    if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
   
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $car_name = $brand . "_" . $model . "_" . $year;
            $car_img = $targetFile;

            $query = "INSERT INTO car_details (user_id, booking_id, car_name, registration_no, car_img, book_status, fee) VALUES ('$user_id', 0, '$car_name', '$registration_no', '$car_img', 0,'$fee')";
            if (mysqli_query($con, $query)) {
                $msg = "Car information inserted successfully.";
            } else {
                $msg = "Error: " . $query . "<br>" . mysqli_error($con);
            }
        } else {
            $msg = "Sorry, there was an error uploading your file.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/renterCarListing.css">
    <link rel="stylesheet" href="../css/home.css">
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
                <a href="#">Home</a>
                <a href="#">Cars</a>
                <a href="#">About Us</a>
                <a href="#">Contact</a>
                <a href="#">Login/Signup</a>
            </div>
        </nav>
    </header>

    <div class="form-wrapper">
        <h2>Car Information Form</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>

            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required>

            <label for="registration">Registration:</label>
            <input type="text" id="registration" name="registration" required>
            <label for="fee">Fee:</label>
            <input type="number" id="fee" name="fee" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <input type="submit" value="Submit" name="submit">
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