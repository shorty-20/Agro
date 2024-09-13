<?php
session_start();
require 'db.php';

try {
    // Debugging: Output a message to check if the script is entering this block

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (!isset($_SESSION['Category'], $_SESSION['id'])) {
            throw new Exception("Session variables not set");
        }

        $category = $_SESSION['Category'];
        $id = $_SESSION['id'];

        

        $pass = $_POST['current_password'];
        $new = $_POST['new_password'];
        $conf_new = $_POST['confirm_new_password'];

        

        if ($category == 1) {
            $sql = "SELECT `fpassword` FROM `farmer` WHERE `fid` ='$id'";
        } else {
            $sql = "SELECT `bpassword` FROM `buyer` WHERE `bid` ='$id'";
        }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Error executing query: " . mysqli_error($conn));
        }

        $User = mysqli_fetch_assoc($result);
        if (!$User) {
            throw new Exception("User not found");
        }
        if($category==1){
            if (!password_verify($pass, $User['fpassword'])) {
                throw new Exception("Incorrect current password");
            }
        }
        else{
            if (!password_verify($pass, $User['bpassword'])) {
                throw new Exception("Incorrect current password");
            }
        }
        
        $new_pass = password_hash($new, PASSWORD_BCRYPT);
        $new_hash = md5( rand(0,1000) );
        if ($category==1) {
            $update = "UPDATE `farmer` SET `fpassword`='$new_pass', `fhash`='$new_hash' WHERE `fid`=$id";
        } else {
            $update = "UPDATE `buyer` SET `bpassword`='$new_pass', `bhash`='$new_hash' WHERE `bid`=$id";
        }

        if (!mysqli_query($conn, $update)) {
            throw new Exception("Error updating password: " . mysqli_error($conn));
        }
        $_SESSION['message'] = "Password updated successfully";
        header("location: index.php");
        exit;
    } else {
        throw new Exception("Invalid request");
    }
} catch (Exception $e) {
    $_SESSION['message'] = "An error occurred: " . $e->getMessage();
    header("location: Login/error.php");
    exit;
}
?>
