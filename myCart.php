<?php
	session_start();
	require 'db.php';
    if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] == 0)
	{
		$_SESSION['message'] = "You need to first login to access this page !!!";
		header("Location: Login/error.php");
	}
    // Initialize the cart flag and cart product price
    $_SESSION['cart_flag'] = 1; // Default value for cart flag
    $_SESSION['cartproductprice'] = 0; // Default value for cart product price
    $_SESSION['productid'] = 13;
    
    $bid = $_SESSION['id'];
    function getProductList($conn, $bid) {
        $productList = "";
        $sql = "SELECT * FROM mycart WHERE bid = '$bid'";
        $result = mysqli_query($conn, $sql);
        while ($row = $result->fetch_array()) {
            $pid = $row['pid'];
            $quantity = $row['quantity'];
            $sql = "SELECT * FROM fproduct WHERE pid = '$pid'";
            $result1 = mysqli_query($conn, $sql);
            $row1 = $result1->fetch_array();
            $productName = $row1['product'];
            // Append product name and quantity to the list
            $productList .= "$productName ($quantity), ";
        }
        // Remove the last comma and space
        $productList = rtrim($productList, ", ");
        return $productList;
    }


    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agri-Business: My Cart</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffffff, #f2f2f2);
        }

        #main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        #welcome-header {
            margin-bottom: 50px; /* Add some margin to create distance from the cards */
            text-align: center; /* Center align the text */
            font-size: 60px; /* Adjust the font size as needed */
        }

        
        .card:hover {
			transform: translateY(-5px);
			box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.2);
		}
        .card {
    background-color: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
    min-width: 300px; /* Adjust this value as needed */
}


        .card-img-top {
            width: 100%;
            height: auto;
        }

        .card-body {
            padding: 20px;
            text-align: left;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
        }

        .card-text {
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            color: #fff;
            background-color: #6ea8ff;
            border-color: #6ea8ff;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            cursor: pointer;
        }
    </style>
</head>

<body style="background: linear-gradient(135deg, #ffffff, #f2f2f2);">

    <!-- Menu PHP Include -->
<?php 
    require 'menu.php';
?>

    <div id="main" class="container mt-5">
    <h1 id="welcome-header">My Cart</h1>

        <!-- Section and Container for Card Display -->
        <section id="cart-products" class="wrapper style2 align-center">
            <div class="container">
                <div class="row">
                    <?php
                    $totalCartPrice = 0;
                    $sql = "SELECT * FROM mycart WHERE bid = '$bid'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = $result->fetch_array()) :
                        $pid = $row['pid'];
                        $sql = "SELECT * FROM fproduct WHERE pid = '$pid'";
                        $result1 = mysqli_query($conn, $sql);
                        $row1 = $result1->fetch_array();
                        $picDestination = "images/productImages/" . $row1['pimage'];
                        if($row['discount'] == '0'){
                            $totalPrice = $row1['price'] * $row['quantity'];
                            $price_name = "Total Price";
                        }
                        else{
                            $discountpercentage = $row['discount'];
                            $discountamount = (100 - $discountpercentage) / 100;
                            $temptotalPrice = $row1['price'] * $row['quantity'];
                            $totalPrice = $temptotalPrice * $discountamount ;
                            $price_name = "Total Discounted Price";
                        }
                        
                        $totalCartPrice += $totalPrice;
                    ?>
                        <div class="col-md-4 mb-4">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $picDestination; ?>" alt="<?php echo $row1['product']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row1['product']; ?></h5>
                                <p class="card-text"><strong>Type:</strong> <?php echo $row1['pcat']; ?></p>
                                <p class="card-text"><strong>Price:</strong> <?php echo $row1['price']; ?> /-</p>
                                <p class="card-text"><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                                <p class="card-text"><strong><?php echo $price_name; ?>:</strong> <?php echo $totalPrice; ?> /-</p>
                                <a href="review.php?pid=<?php echo $row['pid']; ?>" class="btn btn-primary">View Details</a>
                                
                                <!-- Form for removing and decreasing quantity -->
                                <form action="removeFromCart.php" method="post" class="mt-2">
                                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                                    <label for="remove_<?php echo $pid; ?>">Remove completely</label>
                                    <input type="radio" id="remove<?php echo $pid; ?>" name="action" value="remove">
                                    <label for="decrease_<?php echo $pid; ?>" class="mr-2">Decrease quantity</label>
                                    <input type="radio" id="decrease<?php echo $pid; ?>" name="action" value="decrease" checked>
                                    <button type="submit" class="btn btn-danger ml-2">Confirm</button>
                                </form>
                                <!-- Add form for checkout -->
                                <form action="buyNow.php" class="mt-2">
                                    <!-- Hidden input for product total price -->                                    <!-- Hidden input for cart flag (set to 2 for this checkout button) -->
                                    <?php 
                                     $_SESSION['cart_flag'] = 2;
                                     $_SESSION['cartproductprice'] = $totalPrice;
                                     $_SESSION['productid'] = $row['pid'];
                                     ?>
                                    <!-- Checkout button with total price -->
                                    <button type="submit" class="btn btn-primary">Checkout (<?php echo $totalPrice; ?>)</button>
                                </form>
                                <!-- End of checkout form -->
                                <!-- End of Form for removing and decreasing quantity -->
                            </div>
                        </div>
                    </div>


                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <!-- End of Section and Container for Card Display -->

        <!-- Total Cart Price and Checkout Button -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><strong>Total Cart Price: <?php echo $totalCartPrice; ?></strong></h4>
                        <form action="buyNow.php">
                            <button type="submit" class="btn btn-primary">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php
$_SESSION['totalcartprice']=$totalCartPrice;
?>