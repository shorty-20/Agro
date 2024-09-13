<?php
session_start();
require '../db.php';
$category = $_SESSION['Category'];
echo "Email from URL: ".$_GET['email']."<br>";
echo "Verification Code from URL: ".$_GET['v_code']."<br>";
if(isset($_GET['email']) && isset($_GET['v_code'])) 
{
    $email = dataFilter($_GET['email']);
    $v_code = dataFilter($_GET['v_code']);

    // Debug: Output sanitized email and v_code
    echo "Sanitized Email: ".$email."<br>";
    echo "Sanitized Verification Code: ".$v_code."<br>";

    if($category == 1)
    {
        $query = "SELECT * FROM `farmer` WHERE `femail`='$email' AND `verification_code`='$v_code'";
        $result1 = mysqli_query($conn, $query);

        echo "Query: ".$query."<br>";

        if($result1) {
            if ($result1->num_rows == 1) {
                $result1_fetch = mysqli_fetch_assoc($result1);
                if($result1_fetch['is_verified'] == 0) {
                    $update = "UPDATE `farmer` SET `is_verified`=1 WHERE `femail`='$email'";
                    if(mysqli_query($conn, $update)) {
                        $_SESSION['message'] = 'Email verification successful';
                        header('Location: ../index.php');
                        exit();
                    } else {
                        $_SESSION['message'] = 'Error updating database';
                        header('Location: ../index.php');
                        exit();
                    }
                } else {
                    $_SESSION['message'] = 'Email already registered';
                    header('Location: ../index.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = 'Email or verification code incorrect';
                header('Location: ../index.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'Error executing query';
            header('Location: ../index.php');
            exit();
        }
    }
    else {
        $query = "SELECT * FROM `buyer` WHERE `bemail`='$email' AND `verification_code`='$v_code'";
        $result1 = mysqli_query($conn, $query);

        if($result1) {
            if ($result1->num_rows == 1) {
                $result1_fetch = mysqli_fetch_assoc($result1);
                if($result1_fetch['is_verified'] == 0) {
                    $update = "UPDATE `buyer` SET `is_verified`=1 WHERE `bemail`='$email'";
                    if(mysqli_query($conn, $update)) {
                        $_SESSION['message'] = 'Email verification successful';
                        header('location: ../index.php');
                        exit();
                    } else {
                        $_SESSION['message'] = 'Error updating database';
                        header('location: ../index.php');
                        exit();
                    }
                } else {
                    $_SESSION['message'] = 'Email already registered';
                    header('location: ../index.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = 'Email or verification code incorrect';
                // header('location: ../index.php');
                // exit();
            }
        } else {
            $_SESSION['message'] = 'Error executing query';
            // header('location: ../index.php');
            // exit();
        }
    }
} else {
    $_SESSION['message'] = 'Email or verification code not provided';
    //header('location: ../index.php');
    // exit();
}

function dataFilter($data) {
    $data = trim($data);
    return $data;
}
?>
