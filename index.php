<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Agri-Business</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap\js\bootstrap.min.js"></script>
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="login.css"/>
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script>
    // Check if a message is set in the session
    <?php if(isset($_SESSION['message'])): ?>
        // Display the message using alert
        alert('<?php echo $_SESSION['message']; ?>');
        // Unset the message from the session
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</script>

		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<link rel="stylesheet" href="indexfooter.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>

	<?php
		require 'menu.php';
	?>

		<!-- Banner -->
			<section id="banner" class="wrapper">
				<div class="container">
				<h2>Agri-Business</h2>
				<p>Your Product Our Market</p>
				<br><br>
				<center>
					<div class="row uniform">
						<div class="6u 12u$(xsmall)">
							<button class="button fit" onclick="document.getElementById('id01').style.display='block'" style="width:auto">LOGIN</button>
						</div>

						<div class="6u 12u$(xsmall)">
							<button class="button fit" onclick="document.getElementById('id02').style.display='block'" style="width:auto">REGISTER</button>
						</div>
					</div>
				</center>


			</section>

		<!-- One -->
			<section id="one" class="wrapper style1 align-center">
				<div class="container">
					<header>
						<h2 style="color: black;">Agri-Business</h2>
						<p style="color: black;">Explore the new way of trading...</p>
					</header>
					<div class="row 200%">
						<section class="4u 12u$(small)">
							<i class="icon big rounded fa-clock-o"></i>
							<p style="color: black;">Digital Market</p>
						</section>
						<section class="4u 12u$(small)">
							<i class="icon big rounded fa-comments"></i>
							<p style="color: black;">Agri-Business Review</p>
						</section>
						<section class="4u$ 12u$(small)">
							<i class="icon big rounded fa-user"></i>
							<p style="color: black;">Register with us</p>
						</section>
					</div>
				</div>
			</section>


		<!-- Footer -->
		<footer class="footer-distributed" style="background-color:black" id="aboutUs">
		<center>
			<h1 style="font: 35px calibri;">About Us</h1>
		</center>
		<div class="footer-left">
			<h3 style="font-family: 'Times New Roman', cursive;">Agri-Business &copy; </h3>
		<!--	<div class="logo">
				<a href="index.php"><img src="images/logo.png" width="200px"></a>
			</div>-->
			<br />
			<p style="font-size:20px;color:white">Your product Our market !!!</p>
			<br />
		</div>

		<div class="footer-center">
			<div>
				<i class="fa fa-map-marker"></i>
				<p style="font-size:20px">Agri Business Platform<span>India</span></p>
			</div>
			<div>
				<i class="fa fa-phone"></i>
				<p style="font-size:20px">123456789</p>
			</div>
			<div>
				<i class="fa fa-envelope"></i>
				<p style="font-size:20px"><a href="mailto:Agri-Business@gmail.com" style="color:white">demo@demo.com</a></p>
			</div>
		</div>

		<div class="footer-right">
			<p class="footer-company-about" style="color:white">
				<span style="font-size:20px"><b>About Agri-Business</b></span>
				Agri-Business is e-commerce trading platform for grains & grocerries...
			</p>
			<div class="footer-icons">
				<a  href="#"><i style="margin-left: 0;margin-top:5px;"class="fa fa-facebook"></i></a>
				<a href="#"><i style="margin-left: 0;margin-top:5px" class="fa fa-instagram"></i></a>
				<a href="#"><i style="margin-left: 0;margin-top:5px" class="fa fa-youtube"></i></a>
			</div>
		</div>

	</footer>




<div id="id01" class="modal">

  <form class="modal-content animate" action="Login/login.php" method='POST'>
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
    <h3>Login</h3>
							<form method="post" action="Login/login.php">
								<div class="row uniform 50%">
									<div class="7u$">
										<input type="text" name="uname" id="uname" value="" placeholder="UserName" style="width:80%" required/>
									</div>
									<div class="7u$">
										<input type="password" name="pass" id="pass" value="" placeholder="Password" style="width:80%" required/>
									</div>
									<div class="3u 12u$(xsmall)">
                            			<input type="checkbox" id="show-password" onchange="togglePasswordVisibility()">
                            			<label for="show-password">Show Password</label>
                        			</div>
								</div>
									<div class="row uniform">
										<p>
				                            <b>Category : </b>
				                        </p>
				                        <div class="3u 12u$(small)">
				                            <input type="radio" id="farmer" name="category" value="1" checked>
				                            <label for="farmer">Farmer</label>
				                        </div>
				                        <div class="3u 12u$(small)">
				                            <input type="radio" id="buyer" name="category" value="0">
				                            <label for="buyer">Buyer</label>
				                        </div>
									</div>
									<center>
									<div class="row uniform">
										<div class="7u 12u$(small)">
											<input type="submit" value="Login" />
										</div>
									</div>
									</center>
								</div>
							</form>
						</section>
</div>
    </div>
    </div>
  </form>
</div>


<div id="id02" class="modal">
    <form class="modal-content animate" method="POST" id="signup-form" onsubmit="return validateForm()">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <div class="container">
            <section>
                <h3>SignUp</h3>
                <div id="password-strength-message"></div>
                <div id="password-match-message"></div> <!-- Display message for password match -->
                <center>
                    <div class="row uniform">
                        <div class="3u 12u$(xsmall)">
                            <input type="text" name="name" id="name" value="" placeholder="Name" required/>
                        </div>
                        <div class="3u 12u$(xsmall)">
                            <input type="text" name="uname" id="uname" value="" placeholder="UserName" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="3u 12u$(xsmall)">
                            <input type="text" name="mobile" id="mobile" value="" placeholder="Mobile Number" required/>
                        </div>
                        <div class="3u 12u$(xsmall)">
                            <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="3u 12u$(xsmall)">
                            <input type="password" name="password" id="password" value="" placeholder="Password" required onkeyup="checkPasswordStrength();"/>
                        </div>
                        <div class="3u 12u$(xsmall)">
                            <input type="checkbox" id="show-password" onchange="togglePasswordVisibility()">
                            <label for="show-password">Show Password</label>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="3u 12u$(xsmall)">
                            <input type="password" name="pass" id="confirm-password" value="" placeholder="Retype Password" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 12u$(xsmall)">
                            <input type="text" name="addr" id="addr" value="" placeholder="Address" style="width:80%" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <p><b>Category:</b></p>
                        <div class="3u 12u$(small)">
                            <input type="radio" id="farmerReg" name="category" value="1" checked>
                            <label for="farmerReg">Farmer</label>
                        </div>
                        <div class="3u 12u$(small)">
                            <input type="radio" id="buyerReg" name="category" value="0">
                            <label for="buyerReg">Buyer</label>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="3u 12u$(small)">
                            <input type="submit" value="Submit" name="submit" class="special" id="submit-btn" />
                        </div>
                        <div class="3u 12u$(small)">
                            <input type="reset" value="Reset" name="reset"/>
                        </div>
                    </div>
                </center>
            </section>
        </div>
    </form>
</div>

<script>

function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
		var confirmPasswordInput = document.getElementById("confirm-password");
		var loginPasswordInput = document.getElementById("pass");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
			confirmPasswordInput.type = "text";
			loginPasswordInput.type = "text";
        } else {
            passwordInput.type = "password";
			confirmPasswordInput.type = "password";
			loginPasswordInput.type = "password";
        }

    }

function checkPasswordStrength() {
    var password = document.getElementById("password").value;
    var strengthMessage = document.getElementById("password-strength-message");

    // Reset password strength message
    strengthMessage.innerHTML = "";

    // Check password strength
    var hasUpperCase = /[A-Z]/.test(password);
    var hasLowerCase = /[a-z]/.test(password);
    var hasNumbers = /\d/.test(password);
    var hasSpecialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);

    if (password.length < 8) {
        strengthMessage.innerHTML = "Password must be at least 8 characters long.";
        return;
    }

    if (!hasUpperCase) {
        strengthMessage.innerHTML = "Password must contain at least one uppercase letter.";
        return;
    }

    if (!hasLowerCase) {
        strengthMessage.innerHTML = "Password must contain at least one lowercase letter.";
        return;
    }

    if (!hasNumbers) {
        strengthMessage.innerHTML = "Password must contain at least one number.";
        return;
    }

    if (!hasSpecialChars) {
        strengthMessage.innerHTML = "Password must contain at least one special character.";
        return;
    }

    // If all checks pass, indicate strong password
    strengthMessage.innerHTML = "Strong password!";
}

function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var strengthMessage = document.getElementById("password-strength-message");
    var matchMessage = document.getElementById("password-match-message");
    var form = document.getElementById("signup-form");

    // Reset password strength and match messages
    strengthMessage.innerHTML = "";
    matchMessage.innerHTML = "";

    // Check password strength
    // (Assuming checkPasswordStrength() function checks password strength)
    checkPasswordStrength();

    // Log the values of password and confirmPassword
    console.log("Password:", password);
    console.log("Confirm Password:", confirmPassword);

    // Check if passwords match
    if (password !== confirmPassword) {
        matchMessage.innerHTML = "Passwords do not match.";
        return false;
    }

    // If password is not strong, prevent form submission
    if (strengthMessage.innerHTML !== "Strong password!") {
        return false;
    }

    // Set the form action to submit to signup.php
    form.action = "Login/signUp.php";
    return true;
}



  // Add event listener to the form submission event
//   document.getElementById("id02").addEventListener("submit", validateForm);





</script>


	</body>
</html>
