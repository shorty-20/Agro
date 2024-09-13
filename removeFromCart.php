<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pid'], $_POST['action'])) {
    $pid = $_POST['pid'];
    $action = $_POST['action'];

    if ($action === 'remove') {
        // Delete the product from mycart table
        $sql_select = "SELECT quantity FROM mycart WHERE pid = '$pid'";
        $sql_select_product = "SELECT quantity FROM fproduct WHERE pid = '$pid'";
        $result_select = mysqli_query($conn, $sql_select);
        $result_select_product = mysqli_query($conn, $sql_select_product);
        $row = mysqli_fetch_assoc($result_select);
        $row_product = mysqli_fetch_assoc($result_select_product);
        $quantity = $row['quantity'];
        $product_quantity = $row_product['quantity'];
        $new_product_quantity = $product_quantity + $quantity;

        $sql_update = "UPDATE fproduct SET quantity = '$new_product_quantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql_update)) {
                $_SESSION['message'] = "Product Quantity of product increased";

            }


        $sql = "DELETE FROM mycart WHERE pid = '$pid'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Product removed from cart successfully";
        } else {
            $_SESSION['message'] = "Error removing product from cart: " . mysqli_error($conn);
        }
    } elseif ($action === 'decrease') {
        // Decrease the quantity of the product in mycart table
        $sql_select = "SELECT quantity FROM mycart WHERE pid = '$pid'";
        $sql_select_product = "SELECT quantity FROM fproduct WHERE pid = '$pid'";
        $result_select = mysqli_query($conn, $sql_select);
        $result_select_product = mysqli_query($conn, $sql_select_product);
        $row = mysqli_fetch_assoc($result_select);
        $row_product = mysqli_fetch_assoc($result_select_product);
        $quantity = $row['quantity'];
        $product_quantity = $row_product['quantity'];
        $new_product_quantity =$product_quantity+ 1 ;

        // If the quantity is already 1, remove the product entirely
        if ($quantity == 1) {
            $sql_delete = "DELETE FROM mycart WHERE pid = '$pid'";
            $sql_update = "UPDATE mycart SET quantity = '$product_quantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql_update)) {
                $_SESSION['message'] = "Product Quantity of product increased";

            }
            if (mysqli_query($conn, $sql_delete)) {
                // $_SESSION['message'] = "Product removed from cart successfully";
            } else {
                $_SESSION['message'] = "Error removing product from cart: " . mysqli_error($conn);
            }
        } else {
            // Decrease the quantity by 1
            $new_quantity = $quantity - 1;
            $new_product_quantity = $product_quantity + 1;
            $sql_update = "UPDATE mycart SET quantity = '$new_quantity' WHERE pid = '$pid'";
            if (mysqli_query($conn, $sql_update)) {
                $_SESSION['message'] = "Cart Quantity of product decreased";
                $sql_update = "UPDATE fproduct SET quantity = '$new_product_quantity' WHERE pid = '$pid'";
                if (mysqli_query($conn, $sql_update)) {
                    $_SESSION['message'] = "Product Quantity of product increased";

                }
            } else {
                $_SESSION['message'] = "Error decreasing quantity: " . mysqli_error($conn);
            }
        }
    } else {
        $_SESSION['message'] = "Invalid action";
    }
} else {
    $_SESSION['message'] = "Invalid request";
}

// Redirect back to the cart page
header("Location: myCart.php");
exit();
?>
