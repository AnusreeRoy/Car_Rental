<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include('../php/db.php');

if (isset($_POST['pay'])) {
    $user_id = $_SESSION['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $exp_month = $_POST['exp_month'];
    $exp_year = $_POST['exp_year'];
    $cvv =$_POST['cvv'];

    // Insert payment details into the database with payment_status set to 'paid'
    $query = "INSERT INTO payment_details (user_id, full_name, email, address, card_name, card_number, exp_month, exp_year, cvv, payment_status) 
              VALUES ('$user_id', '$full_name', '$email', '$address', '$card_name', '$card_number', '$exp_month', '$exp_year', '$cvv', 'paid')";
    
     if (mysqli_query($con, $query)) {
        echo "<script>alert('Payment successful. Redirecting to dashboard...');</script>";
        echo "<script>setTimeout(function() {
                window.location.href = 'renter_dashboard.php?id=" . $_SESSION['id'] . "';
            }, 2000);</script>";
        exit();
    } else {
        echo "<script>alert('Payment failed. Please try again.'); window.history.back();</script>";
    }
    exit();
}
?>

<!DOCTYPE html> 
<html lang="en"> 

<head> 
	<meta charset="UTF-8"> 
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0"> 
	<title>Online Payment-Page</title> 
	<link rel="stylesheet" href="../css/payment.css"> 
</head> 

<body> 
	<div class="container"> 

		<form id="paymentForm" action="payment.php" method="post"> 

			<div class="row"> 

				<div class="col"> 
					<h3 class="title"> 
						Billing Address 
					</h3> 

					<div class="inputBox"> 
						<label for="name"> 
							Full Name: 
						</label> 
						<input type="text" id="name" name="full_name"
							placeholder="Enter your full name"
							required> 
					</div> 

					<div class="inputBox"> 
						<label for="email"> 
							Email: 
						</label> 
						<input type="text" id="email" name="email"
							placeholder="Enter email address"
							required> 
					</div> 

					<div class="inputBox"> 
						<label for="address"> 
							Address: 
						</label> 
						<input type="text" id="address" name="address"
							placeholder="Enter address"
							required> 
					</div> 
					<div class="inputBox"> 
						<label for="cardName"> 
							Name On Card: 
						</label> 
						<input type="text" id="cardName" name="card_name"
							placeholder="Enter card name"
							required> 
					</div> 

					<div class="inputBox"> 
						<label for="cardNum"> 
							Credit Card Number: 
						</label> 
						<input type="text" id="cardNum" name="card_number"
							placeholder="1111-2222-3333-4444"
							maxlength="19" required> 
					</div> 

					<div class="inputBox"> 
						<label for="">Exp Month:</label> 
						<select name="exp_month" id=""> 
							<option value="">Choose month</option> 
							<option value="January">January</option> 
							<option value="February">February</option> 
							<option value="March">March</option> 
							<option value="April">April</option> 
							<option value="May">May</option> 
							<option value="June">June</option> 
							<option value="July">July</option> 
							<option value="August">August</option> 
							<option value="September">September</option> 
							<option value="October">October</option> 
							<option value="November">November</option> 
							<option value="December">December</option> 
						</select> 
					</div> 


					<div class="flex"> 
						<div class="inputBox"> 
							<label for="">Exp Year:</label> 
							<select name="exp_year" id=""> 
								<option value="">Choose Year</option> 
								<option value="2023">2023</option> 
								<option value="2024">2024</option> 
								<option value="2025">2025</option> 
								<option value="2026">2026</option> 
								<option value="2027">2027</option> 
							</select> 
						</div> 

						<div class="inputBox"> 
							<label for="cvv">CVV</label> 
							<input type="number" id="cvv" name="cvv"
								placeholder="1234" required> 
						</div> 
					</div> 

				</div> 

			</div> 

			<input type="submit" value="Proceed to Checkout" name="pay"
				class="submit_btn"> 
		</form> 

	</div> 
	
    <script>

let cardNumInput =  
    document.querySelector('#cardNum') 
  
cardNumInput.addEventListener('keyup', () => { 
    let cNumber = cardNumInput.value 
    cNumber = cNumber.replace(/\s/g, "") 
  
    if (Number(cNumber)) { 
        cNumber = cNumber.match(/.{1,4}/g) 
        cNumber = cNumber.join(" ") 
        cardNumInput.value = cNumber 
    } 
})
    </script> 
</body> 

</html>
