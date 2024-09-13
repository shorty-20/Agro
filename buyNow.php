<?php
	session_start();
	require 'db.php';
    $bid=$_SESSION['id'];
    $cart_flag=$_GET['cart_flag'];
    if($_SESSION['cart_flag'] == 2){
        $totalPrice=$_SESSION['cartproductprice'];
    }
    else{
        $totalPrice=$_SESSION['totalcartprice'];
    }
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $pincode = $_POST['pincode'];
        $addr = $_POST['addr'];

        $sql = "INSERT INTO transaction (bid, name, city, mobile, email, pincode, addr, total_price)
                VALUES ('$bid', '$name', '$city', '$mobile', '$email', '$pincode', '$addr', '$totalPrice')";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            if($_SESSION['cart_flag'] == 2){
                $productid = $_SESSION['productid'];
                $delete = "DELETE FROM `mycart` WHERE `pid` = '$productid' AND `bid` = '$bid'";
                $resultd = mysqli_query($conn, $delete);
                if($resultd){
                    $_SESSION['message'] = "Order Succesfully placed! <br /> Thanks for shopping with us!!!";
                    header('Location: Login/success.php');
                }
                else{
                    $_SESSION['message'] = "Order Succesfully placed! <br /> Thanks for shopping with us!!!";
                    header('Location: Login/success.php');
                }

            }
            else{
                $delete = "DELETE FROM `mycart` WHERE `bid` = '$bid'";
                $resultd = mysqli_query($conn, $delete);
                $_SESSION['message'] = "Order Succesfully placed! <br /> Thanks for shopping with us!!!";
                header('Location: Login/success.php');
                if($resultd){
                    $_SESSION['message'] = "Order Succesfully placed! <br /> Thanks for shopping with us!!!";
                    header('Location: Login/success.php');
                }
                else{
                    $_SESSION['message'] = "Order Succesfully placed! <br /> Thanks for shopping with us!!!";
                    header('Location: Login/success.php');
                }
            }
            
        }
        else {
            echo $result->mysqli_error();
            $_SESSION['message'] = "Sorry!<br />Order was not placed";
            header('Location: Login/error.php');
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Agri-Business: Transaction</title>
	<meta lang="eng">
	<meta charset="UTF-8">
	<title>Agri-Business</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
	<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
	<script src="js/jquery.min.js"></script>
	<script src="js/skel.min.js"></script>
	<script src="js/skel-layers.min.js"></script>
	<script src="js/init.js"></script>
	<link rel="stylesheet" href="Blog/commentBox.css" />
	<noscript>
		<link rel="stylesheet" href="css/skel.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style-xlarge.css" />
	</noscript>
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var city = document.getElementById('city').value;
            var mobile = document.getElementById('mobile').value;
            var email = document.getElementById('email').value;
            var pincode = document.getElementById('pincode').value;
            var addr = document.getElementById('addr').value;

            var mobilePattern = /^\d{10}$/;
            var pincodePattern = /^\d{6}$/;
            var emailPattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

            if (!name || !city || !mobile || !email || !pincode || !addr) {
                alert("Please fill in all fields.");
                return false;
            }

            if (!mobile.match(mobilePattern)) {
                alert("Mobile number should be 10 digits numeric.");
                return false;
            }

            if (!pincode.match(pincodePattern)) {
                alert("Pincode should be numeric and less than 6 digits.");
                return false;
            }

            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

    <?php
        require 'menu.php';
    ?>


    <section id="main" class="wrapper" >
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">Transaction Details</h2>
                    <form method="post" action="buyNow.php" class="form-horizontal" style="border: 1px solid black; padding: 15px;" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="name">Name:</label>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="city">City:</label>
                            <div class="col-md-9">
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="mobile">Mobile Number:</label>
                            <div class="col-md-9">
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="email">Email:</label>
                            <div class="col-md-9">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="pincode">Pincode:</label>
                            <div class="col-md-9">
                                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="addr">Address:</label>
                            <div class="col-md-9">
                                <textarea name="addr" id="addr" class="form-control" placeholder="Address" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <input type="submit" value="Confirm Order" class="btn btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
