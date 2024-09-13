<?php
    session_start();

    // Ensure that the user is logged in before proceeding with logout
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        require '../db.php'; // Include database connection

        // Get the username of the logged-in user from the session
        $user = $_SESSION['Username'];

        $category = $_SESSION['Category'];
        if($category == 1) {
            $update = "UPDATE `farmer` SET `factive`= 0 WHERE `fusername`='$user'";
        } else {
            $update = "UPDATE `buyer` SET `bactive`= 0 WHERE `busername`='$user'";
        }

        // Execute the update query
        if(mysqli_query($conn, $update)) {
            // Unset all of the session variables
            session_unset();

            // Destroy the session
            session_destroy();

			$_SESSION['message'] = "Sucessfully Logged out";
            header("location: ../index.php");
            exit;
        } else {
            // Display an error message on the logout page
            $_SESSION['message'] = "Logout was not successful. Please try again.";
            header("location: error.php");
            exit;
        }
    } else {
        // If the user is not logged in, redirect them to the homepage or any other desired page
        header("location: ../index.php");
        exit;
    }
?>


<!DOCTYPE html>
<html>
	<head>
        <title>Agri-Business: LogOut</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="../bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="../bootstrap\js\bootstrap.min.js"></script>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/skel.min.js"></script>
		<script src="../js/skel-layers.min.js"></script>
		<script src="../js/init.js"></script>
		<link rel="stylesheet" href="../css/skel.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/style-xlarge.css" />
    </head>

	<body>
	   <?php
            require 'menu.php';
        ?>
	    <section id="banner">
			<div class="container">
                <header class="major">
                    <h2>Thanks for visiting !!!</h2>
					<center>
                    	<p>You have been succesfully logged out !!!</p>
                        <div class="6u 12u$(xsmall)">
							<br />
                            <a href="../index.php" class="button special">HOME</a>
                        </div>
                    </center>
                </header>
                </div>
            </div>
        </section>

    		<script src="../assets/js/jquery.min.js"></script>
            <script src="../assets/js/jquery.scrolly.min.js"></script>
            <script src="../assets/js/jquery.scrollex.min.js"></script>
            <script src="../assets/js/skel.min.js"></script>
            <script src="../assets/js/util.js"></script>
            <script src="../assets/js/main.js"></script>
	</body>
</html>
