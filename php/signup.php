<?php
include('../php/db.php');
$msg="";
if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Check if the email already exists in the database
    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
    $num_rows = mysqli_num_rows($result); // Number of rows returned by the query
    echo "Num rows: " . $num_rows; // Debugging statement
    
    if ($num_rows > 0) {
    
        $msg = "This email address is already registered. Please use a different email.";
    } else {

        $verification_id = rand(111111111, 999999999);
        
        mysqli_query($con, "INSERT INTO users (email, password, phone, verification_status, verification_id) VALUES ('$email','$password', '$phone', 0, $verification_id)");

        $msg = "A verification link has been sent to your <strong>$email</strong>. Please check your inbox.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <title>Car-Let:SignUp</title>
</head>
<body>
    <div class="signup-container">
        <form id="signupForm" action="../php/signup.php" method="post" onsubmit="return validateForm()">
            <h2>Car-Let: Sign Up</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span id="passwordError" style="color: red;"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <button type="submit" id="signup-btn" name="signup"  onsubmit="disableButton()">Sign Up</button>
            </div>
            <?php
            echo $msg;
            ?>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
    <script>
function disableButton() {
    document.getElementById("signup-btn").disabled = true;
}
function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var passwordError = document.getElementById("passwordError");

            if (password !== confirmPassword) {
                passwordError.textContent = "Passwords do not match";
                return false; 
            } else {
                passwordError.textContent = ""; 
                return true; 
            }
        }
</script>
</body>
</html>