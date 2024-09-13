<?php
session_start();
require 'db.php';
$pid = $_GET['pid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the quantity from the form
    

    $quantity =  $_POST['quantityinc'];
    // Retrieve the current quantity from the database
    $sql = "SELECT * FROM `fproduct` WHERE `pid` = '$pid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $pquantity =$row['quantity'];
    // Calculate the new quantity after adding to cart
    $newQuantity = $pquantity + $quantity;
    $sql = "UPDATE `fproduct` SET `quantity` = '$newQuantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql)) {
                    $_SESSION['message'] = "Success";
                    header("location: myProduct.php");
                
            } else {
                    $_SESSION['message'] = "error updating quantity";
                    header("location: productMenu.php");
            }

            exit();

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
                    <p style="font: 50px Times New Roman;"><?= $row['product']; ?></p>
                    <p style="font: 30px Times New Roman;">Product Owner: <?= $frow['fname']; ?></p>
                    <p style="font: 30px Times New Roman;">Price: <?= $row['price'].' /-'; ?></p>
                    <p style="font: 30px Times New Roman;">Available Quantity: <?= $row['quantity']; ?></p>
					<p style="font: 30px Times New Roman;">Expiry Date: <?= $row['expiry_date']; ?></p> <!-- Displaying Expiry Date -->
                    <form method="POST" action="donate.php?pid=<?php echo $pid; ?>">
                        <input type="submit" value="Donate" class="btn btn-primary" style="background-color: #007acc;">
                    </form>
                    <form method="POST" action="">
                        <p style="font: 30px Times New Roman; color: black;">Increase Quantity: <input type="number" name="quantityinc" min="1" required></p>
                        <input type="submit" value="Increase Quantity" class="btn btn-primary" style="background-color: #007acc;">
                    </form>
                </div>
            </div><br />
            <div class="row">
                <div class="col-12 col-sm-12" style="font: 25px Times New Roman;">
                    <?= $row['pinfo']; ?>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
