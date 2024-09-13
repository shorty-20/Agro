<?php
    session_start();

    $user = dataFilter($_POST['uname']);
    $pass = $_POST['pass'];
    $category = dataFilter($_POST['category']);

    require '../db.php';

if($category == 1)
{
    $sql = "SELECT * FROM `farmer` WHERE `fusername` = '$user'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if($num_rows == 0)
    {
        $_SESSION['message'] = "Invalid User Credentialss!";
        header("location: error.php");
    }

    else
    {
        
        $User = mysqli_fetch_assoc($result);
        if($User['is_verified'] == 0){
            $_SESSION['message'] = "Please verify your account first";
            header("location: ../index.php");
        }
        

        else if(password_verify($_POST['pass'], $User['fpassword']))
        {
            $update = "UPDATE `farmer` SET `factive`= 1 WHERE `fusername`='$user'";
            if(mysqli_query($conn, $update)){
            $_SESSION['id'] = $User['fid'];
            $_SESSION['Hash'] = $User['fhash'];
            $_SESSION['Password'] = $User['fpassword'];
            $_SESSION['Email'] = $User['femail'];
            $_SESSION['Name'] = $User['fname'];
            $_SESSION['Username'] = $User['fusername'];
            $_SESSION['Mobile'] = $User['fmobile'];
            $_SESSION['Addr'] = $User['faddress'];
            $_SESSION['Rating'] = $User['frating'];
            $_SESSION['verification_code'] = $User['verification_code'];
            $_SESSION['is_verified'] = $User['is_verified'];
            $_SESSION['logged_in'] = true;
            $_SESSION['Category'] = 1;
            $_SESSION['farmer'] = true;
            header("location: ./profile.php");
            }
            else{
            $_SESSION['message'] = "something went wrong";
            header("location: error.php");
            }
        }
        else
        {
            $_SESSION['message'] = "Invalid User Credentials!";
            header("location: error.php");
        }
    }
}
else
{
    $sql = "SELECT * FROM `buyer` WHERE `busername`='$user'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if($num_rows == 0)
    {
        $_SESSION['message'] = "Invalid User Credentialss!";
        header("location: error.php");
    }

    else
    {
        $User = mysqli_fetch_assoc($result);
        if($User['is_verified'] == 0){
            $_SESSION['message'] = "Please verify your account first";
            header("location: ../index.php");
        }
        

        else if (password_verify($_POST['pass'], $User['bpassword']))
        {
            $update = "UPDATE `buyer` SET `bactive`= 1 WHERE `busername`='$user'";
            if(mysqli_query($conn, $update)){
            $_SESSION['id'] = $User['bid'];
            $_SESSION['Hash'] = $User['bhash'];
            $_SESSION['Password'] = $User['bpassword'];
            $_SESSION['Email'] = $User['bemail'];
            $_SESSION['Name'] = $User['bname'];
            $_SESSION['Username'] = $User['busername'];
            $_SESSION['Mobile'] = $User['bmobile'];
            $_SESSION['Addr'] = $User['baddress'];
            $_SESSION['verification_code'] = $User['verification_code'];
            $_SESSION['is_verified'] = $User['is_verified'];
            $_SESSION['logged_in'] = true;
            $_SESSION['Category'] = 0;
            $_SESSION['farmer'] = false;
            header("location: profile.php");
            }
            else{
                $_SESSION['message'] = "something went wrong";
                header("location: error.php");
                }
        }
        else
        {
            $_SESSION['message'] = "Invalid User Credentials!";
            header("location: error.php");
        }
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
