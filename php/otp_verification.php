<?php
include('../php/db.php');
if (isset($_POST['verify'])) {
    $enteredOTP = $_POST['verification_id'];
    
    // Retrieve the email from the session (assuming you stored it during signup)
    session_start();
    $email = $_SESSION['email'];

    // Fetch the verification_id associated with the email from the database
    $query = "SELECT verification_id FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $storedOTP = $row['verification_id'];
        if ($enteredOTP == $storedOTP) {
            echo "OTP verified successfully.";
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "login.php";
                    }, 2000);
                  </script>';
            exit();
        } else {
            // Incorrect OTP, set error message
            echo"Invalid OTP. Please try again.";
        }
    } else {
        // Email not found in database
        $error = "Email not found. Please sign up or try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h2>OTP Verification</h2>
    <!-- Display success or error message -->
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form action="otp_verification.php" method="post">
        <label for="verification_id">Enter OTP sent to your email:</label>
        <input type="text" id="verification_id" name="verification_id" required><br>
        <button type="submit" name="verify">Verify OTP</button>
    </form>
</body>
</html>
