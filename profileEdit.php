<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'db.php';



try {
    // Debugging: Output a message to check if the script is entering this block

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (!isset($_SESSION['Category'], $_SESSION['id'])) {
            throw new Exception("Session variables not set");
        }

        $category = $_SESSION['Category'];
        $id = $_SESSION['id'];

        // Debugging: Output the values of session variables
        
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $uname = mysqli_real_escape_string($conn, $_POST['uname']);
        $email = $_POST['email'];
        $address = mysqli_real_escape_string($conn, $_POST['address']);


        

        $updateFields = array();
        if($category==1){
            if (!empty($name)) {
                $updateFields[] = "`fname`='$name'";
            }
            if (!empty($mobile)) {
                $updateFields[] = "`fmobile`='$mobile'";
            }
            if (!empty($uname)) {
                $updateFields[] = "`fusername`='$uname'";
            }
            if (!empty($email)) {
                $updateFields[] = "`femail`='$email'";
            }
            if (!empty($address)) {
                $updateFields[] = "`faddress`='$address'";
            }
        }
        else{
            if (!empty($name)) {
                $updateFields[] = "`bname`='$name'";
            }
            if (!empty($mobile)) {
                $updateFields[] = "`bmobile`='$mobile'";
            }
            if (!empty($uname)) {
                $updateFields[] = "`busername`='$uname'";
            }
            if (!empty($email)) {
                $updateFields[] = "`bemail`='$email'";
            }
            if (!empty($address)) {
                $updateFields[] = "`baddress`='$address'";
            }
        }
        

        if ($category == 1) {
            $table = 'farmer';
            $username = 'fusername';
            $user_id = 'fid';
            $mailn = 'femail';
        } else {
            $table = 'buyer';
            $username = 'busername';
            $user_id = 'bid';
            $mailn = 'bemail';
        }

        
        $sql = "SELECT `$username` FROM `$table` WHERE `$user_id` ='$id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Error executing query: " . mysqli_error($conn));
        }

        $User = mysqli_fetch_assoc($result);
        if (!$User) {
            throw new Exception("User not found");
        }

        $updateFieldsStr = implode(', ', $updateFields);
        $update = "UPDATE `$table` SET $updateFieldsStr WHERE `fid`='$id'";
        

        if (!mysqli_query($conn, $update)) {
            throw new Exception("Error updating profile: " . mysqli_error($conn));
        }
        if(!empty($email)){
            $v_code = bin2hex(random_bytes(16));
            $updatem = "UPDATE `$table` SET `is_verified`=0 , `verification_code`='$v_code' WHERE `$mailn`='$email'";
        if(mysqli_query($conn, $updatem) && sendmail($email,$v_code))
    	{   echo "Profile start...";
            $_SESSION['message'] = "Profile updated successfully";
            header("location: Login/logout.php");
        }
        else{
            $_SESSION['message'] = "Registration failed!";
            header("location: error.php");
        }        
        }
        header("location: Login/logout.php");
        exit;
    } else {
        throw new Exception("Invalid request");
    }
} catch (Exception $e) {
    $_SESSION['message'] = "An error occurred: " . $e->getMessage();
    header("location: Login/error.php");
    exit;
}




function sendmail($email,$v_code)
{
	require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'adityasingh181204@gmail.com';                     //SMTP username
        $mail->Password   = 'uedc huuy qtrx eywr';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('adityasingh181204@gmail.com', 'Agri-Business Admin');
        $mail->addAddress($email);     //Add a recipient
        
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification From Agri-Business';
        $mail->Body    = "Thanks for registeration!
        Click the below link to verify your email
        <a href=localhost/Agri/Login/verify.php?email=$email&v_code=$v_code>Verify</a>";
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


?>
