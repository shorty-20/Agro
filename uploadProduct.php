<?php
 	session_start();
	require 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		$productType = $_POST['type'];
		$productName = dataFilter($_POST['pname']);
		$productInfo = $_POST['description'];
		$productPrice = dataFilter($_POST['price']);
		$productExpiry = $_POST['expiry_date'];
		$productQuantity = $_POST['quantity'];

		
		$fid = $_SESSION['id'];

		$sql = "INSERT INTO fproduct (fid, product, pcat, pinfo, price, expiry_date, quantity)
			   VALUES ('$fid', '$productName', '$productType', '$productInfo', '$productPrice', '$productExpiry', '$productQuantity')";
		$result = mysqli_query($conn, $sql);
		if(!$result)
		{
			$_SESSION['message'] = "Unable to upload Product !!!";
			header("Location: Login/error.php");
		}
		else {
			$_SESSION['message'] = "successfull !!!";
		}

		$pic = $_FILES['productPic'];
		$picName = $pic['name'];
		$picTmpName = $pic['tmp_name'];
		$picSize = $pic['size'];
		$picError = $pic['error'];
		$picType = $pic['type'];
		$picExt = explode('.', $picName);
		$picActualExt = strtolower(end($picExt));
		$allowed = array('jpg','jpeg','png');

		if(in_array($picActualExt, $allowed))
		{
			if($picError === 0)
			{
				$_SESSION['productPicId'] = $_SESSION['id'];
				$picNameNew = $productName.$_SESSION['productPicId'].".".$picActualExt ;
				$_SESSION['productPicName'] = $picNameNew;
				$_SESSION['productPicExt'] = $picActualExt;
				$picDestination = "images/productImages/".$picNameNew;
				move_uploaded_file($picTmpName, $picDestination);
				$id = $_SESSION['id'];

				$sql = "UPDATE fproduct SET picStatus=1, pimage='$picNameNew' WHERE product='$productName';";

				$result = mysqli_query($conn, $sql);
				if($result)
				{

					$_SESSION['message'] = "Product Image Uploaded successfully !!!";
					header("Location: market.php");
				}
				else
				{
					//die("bad");
					$_SESSION['message'] = "There was an error in uploading your product Image! Please Try again!";
					header("Location: Login/error.php");
				}
			}
			else
			{
				$_SESSION['message'] = "There was an error in uploading your product image! Please Try again!";
				header("Location: Login/error.php");
			}
		}
		else
		{
			$_SESSION['message'] = "You cannot upload files with this extension!!!";
			header("Location: Login/error.php");
		}
	}

	function dataFilter($data)
	{
	    $data = trim($data);
	    $data = stripslashes($data);
	    $data = htmlspecialchars($data);
	    return $data;
	}
?>


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
		<link rel="stylesheet" type="text/css" href="indexFooter.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
		
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>

	<?php require 'menu.php'; ?>

<section id="one" class="wrapper style1 align-center">
    <div class="container">
        <form method="POST" action="uploadProduct.php" enctype="multipart/form-data" class="form-horizontal">
		<h2 class="mb-4" style="color: black;">Enter the Product Information here</h2>
            
            <!-- File input -->
            <div class="form-group">
                <label class="col-sm-3 control-label">Product Image:</label>
                <div class="col-sm-9">
                    <input type="file" name="productPic" class="form-control-file">
                </div>
            </div>

            <!-- Category and Product Name -->
            <div class="form-group">
                <label class="col-sm-3 control-label">Category:</label>
                <div class="col-sm-9">
                    <select name="type" id="type" class="form-control">
                        <option value="">- Select Category -</option>
                        <option value="Fruit">Fruit</option>
                        <option value="Vegetable">Vegetable</option>
                        <option value="Grains">Grains</option>
                    </select>
                </div>
            </div>
            <!-- Product Name input field -->
			<div class="form-group">
				<label class="col-sm-3 control-label">Product Name:</label>
				<div class="col-sm-9">
					<input type="text" name="pname" id="quantity" class="form-control" placeholder="Enter Product Name" style="background-color: white; color: black;">
				</div>
			</div>



            <!-- Product Description -->
            <div class="form-group">
                <label class="col-sm-3 control-label">Product Description:</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter Product Description"></textarea>
                </div>
            </div>

            <!-- Price and Quantity input fields -->
			<div class="form-group">
				<label class="col-sm-3 control-label">Price:</label>
				<div class="col-sm-4">
					<input type="number" name="price" id="price" class="form-control" placeholder="Enter Price" style="background-color: white;">
				</div>
				<label class="col-sm-2 control-label">Expiry Date:</label>
				<div class="col-sm-3">
					<input type="date" name="expiry_date" id="expiry_date" class="form-control" placeholder="Expiry Date">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Quantity:</label>
				<div class="col-sm-9">
					<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" style="background-color: white;">
				</div>
			</div>

            <!-- Submit button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>

</body>
</html>
