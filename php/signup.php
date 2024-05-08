<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to PHPMailer autoload.php
session_start();
include('../php/db.php');
$msg="";

function generateOTP() {
    return mt_rand(100000, 999999);
}

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $nid = $_POST['nid'];
    $userType = $_POST['userType'];

    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $msg = "This email is already registered. Please use a different email.";
    } else {

    $verification_id = generateOTP();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'anusree.roy@northsouth.edu'; 
        $mail->Password   = 'Anusreeroy07!';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('anusree.roy@northsouth.edu', 'Anusree');
        $mail->addAddress($email); // Add recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body    = 'Your OTP for account verification is: ' . $verification_id;

        $mail->send();
       
        mysqli_query($con, "INSERT INTO users (email, password, phone, verification_id, nid, userType) VALUES ('$email','$password', '$phone', $verification_id, $nid, '$userType')");

        $_SESSION['email'] = $email;

        $msg = "A verification link has been sent to your email. Please verify your account.";
                echo '<script>
                    setTimeout(function(){
                        window.location.href = "otp_verification.php";
                    }, 2000);
                  </script>';
            exit();

        //header("Location: otp_verification.php");
    } catch (Exception $e) {
        $msg = "Failed to send OTP. Error: {$mail->ErrorInfo}";
    }
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
                <label for="nid">NID:</label>
                <input type="number" id="nid" name="nid" required>
                <span id="nidError" style="color: red;"></span>
            </div>
            <div class="form-group">
            <label for="userType">User Type:</label>
            <select id="userType" name="userType" required>
                <option value="renter">Renter</option>
                <option value="car_owner">Car Owner</option>
            </select>
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
            var nid = document.getElementById("nid").value;
            var nidError = document.getElementById("nidError");

            if (nid.length !== 10) {
                nidError.textContent = "NID must be 10 digits long";
                return false;
            } else {
                nidError.textContent = "";
            }


            if (password !== confirmPassword) {
                passwordError.textContent = "Passwords do not match";
                return false; 
            } else {
                passwordError.textContent = "";  
            }
        }
</script>
</body>
</html>