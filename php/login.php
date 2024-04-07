
<?php
include('../php/db.php');

session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // If login successful, set session variables
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['userType'] = $row['userType'];

        // Redirect to respective dashboard based on user type
        if ($row['userType'] == 'car_owner') {
            header("Location: carowner_dashboard.php?id=" . $row['id']);
            exit();
        } elseif ($row['userType'] == 'renter') {
            header("Location: renter_dashboard.php?id=" . $row['id']);
            exit();
        }
    } else {
        $msg = "Invalid email or password. Please try again.";
        header("Location: login.php?msg=$msg"); // Redirect back to login page with error message
        exit();
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car_Let: Login</title>
<link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <form id="login-form" action="../php/login.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" id="login-btn" name="login">Login</button>
            <?php 
            if ($msg) { 
             echo $msg;
         } 
         ?>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</div>
<script>
    function disableButton() {
    document.getElementById("login-btn").disabled = true;
}
</script>
</body>
</html>
