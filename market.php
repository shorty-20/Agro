<?php
 	session_start();
	if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] == 0)
	{
		$_SESSION['message'] = "You need to first login to access this page !!!";
		header("Location: Login/error.php");
	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Agri-Business</title>
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f2f2f2;
		}
		.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		h2 {
			font-size: 36px;
			font-weight: bold;
			text-align: center;
			color: #333;
			margin-bottom: 40px;
		}
		.card {
			background-color: #fff;
			border-radius: 10px;
			padding: 20px;
			text-align: center;
			transition: all 0.3s ease;
			box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
			margin: 20px 0; /* Add top and bottom margin */

		}
		.card:hover {
			transform: translateY(-5px);
			box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.2);
		}
		.card img {
			width: 100px;
			height: 100px;
			margin-bottom: 20px;
		}
		.card p {
			font-size: 18px;
			color: #666;
		}
	</style>
</head>
<body>

	<?php require 'menu.php'; ?>

	<div class="container">
		<h2>Welcome to Digital Market</h2>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<a href="profileView.php"><img src="profileDefault.png"></a>
					<p>My Profile</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<a href="productMenu.php?n=1" name="catSearch"><img src="search.png"></a>
					<p>Search according to your needs</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<a href="productMenu.php?n=0"><img src="product.png"></a>
					<p>Our products</p>
				</div>
			</div>
		</div>
		<?php if(isset($_SESSION["farmer"]) && $_SESSION["farmer"] == true): ?>
		<!-- New row for the fourth card -->
		
		<div class="row">
			<div class="col-md-4 ">
			</div>
			<div class="col-md-4 ">
				<!-- Fourth card: Your Products -->
				<div class="card">
					<a href="myProduct.php?n=1"><img src="product.png"></a>
					<p>My Products</p>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
	</div>

</body>
</html>
