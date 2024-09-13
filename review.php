<?php
session_start();
require 'db.php';
$pid = $_GET['pid'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the quantity from the form
    $addedQuantity = $_POST['quantity'];
    
    // Retrieve the current quantity from the database
    $sql = "SELECT `quantity` , `fid` FROM `fproduct` WHERE `pid` = '$pid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $currentQuantity = $row['quantity'];
    $fid = $row['fid'];
    $bid = $_SESSION['id'];
    // Calculate the new quantity after adding to cart
    $newQuantity = $currentQuantity - $addedQuantity;

    // Update the quantity in the database
    $sql = "UPDATE `fproduct` SET `quantity` = '$newQuantity' WHERE pid = '$pid'";
    if (mysqli_query($conn, $sql)) {
        // Quantity updated successfully
        
		// Check if the product already exists in mycart table
        $sql_check = "SELECT * FROM `mycart` WHERE `pid` = '$pid' AND `bid` = '$bid'";
        $result_check = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($result_check) > 0) {
            // Product already exists, update its quantity
            $row_check = mysqli_fetch_assoc($result_check);
            $updatedQuantity = $row_check['quantity'] + $addedQuantity;
            $sql_update = "UPDATE `mycart` SET `quantity` = $updatedQuantity WHERE `pid` = '$pid'";
            if (mysqli_query($conn, $sql_update)) {
                // Quantity updated successfully
				
                header("Location: myCart.php?pid=" . $pid);

                exit();
            } else {
                $_SESSION['message'] = "error updating quantity";
            	header("location: productMenu.php");
            }
        } else {
            // Product does not exist, insert new record
            $sql_insert = "INSERT INTO mycart (`bid`, `pid`, `quantity`) VALUES ('$bid', '$pid', '$addedQuantity')";
            if (mysqli_query($conn, $sql_insert)) {
                // Product added to cart successfully
				$_SESSION['message'] = "Added $addedQuantity product to Cart";
            	header("location: productMenu.php");
                header("Location: myCart.php");
                exit();
            } else {
                $_SESSION['message'] = "error adding to cart";
            header("location: productMenu.php");
            }
        }

    } else {
        	$_SESSION['message'] = "error updating quantity";
            header("location: productMenu.php");
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Agri-Business: Product</title>
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
            body{
                background-image: linear-gradient(60deg, #6ea8ff 50%, #f2f2f2 50%);
            }
        </script>
</head>
<body>
    <?php
        require 'menu.php';

        $sql="SELECT * FROM fproduct WHERE pid = '$pid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $fid = $row['fid'];
        $sql = "SELECT * FROM farmer WHERE fid = '$fid'";
        $result = mysqli_query($conn, $sql);
        $frow = mysqli_fetch_assoc($result);

        $picDestination = "images/productImages/".$row['pimage'];
    ?>
    <section id="main" class="wrapper style1 align-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <img class="image fit" src="<?php echo $picDestination;?>" alt="" />
                </div><!-- Image of farmer-->
                <div class="col-12 col-sm-6">
                    <p style="font: 50px Times New Roman; color: black;"><?= $row['product']; ?></p>
                    <p style="font: 30px Times New Roman; color: black;">Product Owner: <?= $frow['fname']; ?></p>
                    <p style="font: 30px Times New Roman; color: black;">Price: <?= $row['price'].' /-'; ?></p>
                    <p style="font: 30px Times New Roman; color: black;">Available Quantity: <?= $row['quantity']; ?></p>
					<p style="font: 30px Times New Roman; color: black;">Expiry Date: <?= $row['expiry_date']; ?></p> <!-- Displaying Expiry Date -->
                    <?php 
                        // Check if the logged-in user is the farmer
                        if ($_SESSION['id'] != $fid) {
                    ?>
                    <form method="POST" action="">
                        <p style="font: 30px Times New Roman; color: black;">Add to Cart: <input type="number" name="quantity" min="1" max="<?= $row['quantity']; ?>" required></p>
                        <input type="submit" value="Add to Cart" class="btn btn-primary" style="color: black; background-color: #007acc;">
                    </form>
                    <?php } ?>
                </div>
            </div><br />
            <div class="row">
                <div class="col-12 col-sm-12" style="font: 25px Times New Roman;">
                    <?= $row['pinfo']; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <h1>Product Reviews</h1>
        <div class="row">
            <?php
                $sql = "SELECT * FROM review WHERE pid='$pid'";
                $result = mysqli_query($conn, $sql);
            ?>
            <div class="col-0 col-sm-3"></div>
            <div class="col-12 col-sm-6">
                <?php
                    if($result) :
                        while($row1 = $result->fetch_array()) :
                ?>
                <div class="con">
                    <div class="row">
                        <div class="col-sm-4">
                            <em style="color: black;"><?= $row1['comment']; ?></em>
                        </div>
                        <div class="col-sm-4">
                            <em style="color: black;"><?php echo "Rating : ".$row1['rating'].' out of 10';?></em>
                        </div>
                    </div>
                    <span class="time-right" style="color: black;"><?php echo "From: ".$row1['name']; ?></span>
                    <br /><br />
                </div>
                <?php endwhile; endif;?>
            </div>
        </div>
    </div>

    <div class="container">
        <p style="font: 20px Times New Roman; align: left;">Rate this product</p>
        <form method="POST" action="reviewInput.php?pid=<?= $pid; ?>">
            <div class="row">
                <div class="col-sm-7">
                    <textarea style="background-color:white;color: black;" cols="5" name="comment" placeholder="Write a review"></textarea>
                </div>
                <div class="col-sm-5">
                    <br />
                    Rating: <input type="number" min="0" max="10" name="rating" value="0"/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br />
                    <?php 
                        // Check if the logged-in user is the farmer
                        if ($_SESSION['id'] != $fid) {
                    ?>
                    <input type="submit" style="color: black; background-color: #007acc;" />
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
