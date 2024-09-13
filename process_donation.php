<?php
session_start();
require 'db.php';
$pid = $_GET['pid'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the quantity from the form
    
    $ngoname = $_POST['ngo'];

    $quantity =  $_POST['addedquantity'];
    // Retrieve the current quantity from the database
    $sql = "SELECT * FROM `fproduct` WHERE `pid` = '$pid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $pname = $row['product'];
    $pcat = $row['pcat'];
    $pinfo = $row['pinfo'];
    $price = $row['price'];
    $pquantity =$row['quantity'];
    // Calculate the new quantity after adding to cart
    $newQuantity = $pquantity - $quantity;

    $sql_check = "SELECT * FROM `donate_table` WHERE `pid` = '$pid' and `donatedto` = '$ngoname'";
    $result_check = mysqli_query($conn, $sql_check);
    if(mysqli_num_rows($result_check) > 0){
        // Product already exists, update its quantity
        $row_check = mysqli_fetch_assoc($result_check);
        $updatedQuantity = $row_check['quantity'] + $quantity;
        $sql_update = "UPDATE `donate_table` SET `quantity` = $updatedQuantity WHERE `pid` = '$pid' and `donatedto`='$ngoname'";
        if (mysqli_query($conn, $sql_update)) {
            // Quantity updated successfully
            // Update the quantity in the database
            $sql = "UPDATE `fproduct` SET `quantity` = '$newQuantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['message'] = "Success";
                    header("location: market.php");
                
            } else {
                    $_SESSION['message'] = "error updating quantity";
                    header("location: productMenu.php");
            }

            exit();
        } else {
            $_SESSION['message'] = "error updating quantity";
            header("location: productMenu.php");
        }
    }
    else{
        // Update the quantity in the database
    $sql = "INSERT INTO donate_table (product_name, category, info, quantity, pid, price, donatedto)
    VALUES ('$pname','$pcat','$pinfo','$quantity','$pid','$price','$ngoname')";
        if (mysqli_query($conn, $sql)) {

            // Update the quantity in the database
            $sql = "UPDATE `fproduct` SET `quantity` = '$newQuantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['message'] = "Success";
                    header("location: market.php");
                
            } else {
                    $_SESSION['message'] = "error updating quantity";
                    header("location: productMenu.php");
            }

                exit();
            } else {
                $_SESSION['message'] = "error donating quantity";
            	header("location: productMenu.php");
            }
} 
    }
    
?>
