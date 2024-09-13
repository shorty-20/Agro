<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = dataFilter($_POST['name']);
	$mobile = dataFilter($_POST['mobile']);
	$user = dataFilter($_POST['uname']);
	$email = dataFilter($_POST['email']);
	$pass =	dataFilter(password_hash($_POST['pass'], PASSWORD_BCRYPT));
	$hash = dataFilter( md5( rand(0,1000) ) );
	$category = dataFilter($_POST['category']);
    $addr = dataFilter($_POST['addr']);

	$_SESSION['Email'] = $email;
    $_SESSION['Name'] = $name;
    $_SESSION['Password'] = $pass;
    $_SESSION['Username'] = $user;
    $_SESSION['Mobile'] = $mobile;
    $_SESSION['Category'] = $category;
    $_SESSION['Hash'] = $hash;
    $_SESSION['Addr'] = $addr;
    $_SESSION['Rating'] = 0;
}


require '../db.php';

$length = dataFilter(strlen($mobile));

if($length != 10)
{
	$_SESSION['message'] = "Invalid Mobile Number !!!";
	header("location: error.php");
	die();
}

if($category == 1)
{
    $sql = "SELECT * FROM `farmer` WHERE `femail`='$email'";

    $result = mysqli_query($conn, "SELECT * FROM `farmer` WHERE `femail`='$email'") or die($mysqli->error());

    if ($result->num_rows > 0 )
    {
        $_SESSION['message'] = "User with this email already exists!";
        header("location: error.php");
    }
    else
    {
        $v_code = bin2hex(random_bytes(16));
    	$sql = "INSERT INTO farmer (fname, fusername, fpassword, fhash, fmobile, femail, faddress, factive, verification_code, is_verified)
    			VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr', '0', '$v_code', '0')";

    	if (mysqli_query($conn, $sql) && sendmail($email,$v_code))
    	{
            $sql = "SELECT * FROM `farmer` WHERE `fusername`='$user'";
            $result = mysqli_query($conn, $sql);
            $User = $result->fetch_assoc();
            $_SESSION['id'] = $User['fid'];

            $_SESSION['message'] ="Confirmation link has been sent to $email, please verify your account";
            header("location: ../index.php");
    	}
    	else
    	{
    	    $_SESSION['message'] = "Registration failed!";
            header("location: error.php");
    	}
    }
}

else
{
    $sql = "SELECT * FROM `buyer` WHERE `bemail`='$email'";

    $result = mysqli_query($conn, "SELECT * FROM `buyer` WHERE `bemail`='$email'") or die($mysqli->error());

    if ($result->num_rows > 0 )
    {
        $_SESSION['message'] = "User with this email already exists!";
        header("location: error.php");
    }
    else
    {
        $v_code = bin2hex(random_bytes(16));
    	$sql = "INSERT INTO buyer (bname, busername, bpassword, bhash, bmobile, bemail, baddress, bactive, verification_code, is_verified)
    			VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr', '0', '$v_code', '0')";

    	if (mysqli_query($conn, $sql) && sendmail($_POST['email'],$v_code))
    	{
            $sql = "SELECT * FROM `buyer` WHERE `busername`='$user'";
            $result = mysqli_query($conn, $sql);
            $User = $result->fetch_assoc();
            $_SESSION['id'] = $User['bid'];

            $_SESSION['message'] ="Confirmation link has been sent to $email, please verify your account";
            header("location: ../index.php");
    	}
    	else
    	{
    	    $_SESSION['message'] = "Registration failed!";
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

function sendmail($email,$v_code)
{
	require("../PHPMailer/PHPMailer.php");
    require("../PHPMailer/SMTP.php");
    require("../PHPMailer/Exception.php");

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
