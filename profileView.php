<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    session_start();
    require 'db.php';
    $category=$_SESSION['Category'];
    $id=$_SESSION['id'];
	if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] != 1)
	{
		$_SESSION['message'] = "You have to Login to view this page!";
		header("Location: Login/error.php");
	}

    $sql = "SELECT * FROM review WHERE userId='$id'";
    $result = mysqli_query($conn, $sql);
    $totalRating = 0;
    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            // Add the rating of the current row to the total rating
            $totalRating += $row['rating'];
            $count += 1;
        }
    } else {
        $count = 1;
        $totalRating = 0;
    }
    $totalRating = $totalRating / $count;


?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Profile: <?php echo $_SESSION['Username']; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
    <body style="background: linear-gradient(135deg, #ffffff, #f2f2f2);">
    <style>
        /* Gradient background */
        body {
            background: linear-gradient(120deg, #ff85a2, #ffc3a0);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        .profile-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: auto;
            display: block;
        }
        .profile-name {
            margin-top: 10px;
            color: #333;
        }
        .profile-info p {
            margin: 5px 0;
            color: #666;
        }
        .btn-group {
            margin-top: 20px;
        }
        .btn-group .btn {
            margin: 10px;
            padding: 15px 40px;
            font-size: 18px;
        }
        /* Style for file input */
        .custom-file-input {
            color: transparent;
        }
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }
        .custom-file-input::before {
            content: 'Select Profile Picture';
            color: #fff;
            background-color: #dc3545;
            border-radius: 5px;
            padding: 8px 20px;
            display: inline-block;
            cursor: pointer;
        }
        .custom-file-input:hover::before {
            background-color: #c82333;
        }
        .custom-file-input:active::before {
            background-color: #bd2130;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <script>
        // Function to display selected profile picture
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profilePicture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function(){
            // Trigger file input on click
            $('.custom-file-input').click(function(){
                $(this).next().trigger('click');
            });

            // Display selected profile picture
            $('#customFile').change(function(){
                readURL(this);
            });
        });
    </script>
</head>
<body>

<?php require 'menu.php'; ?>

<div class="container">
    <div class="profile-box">
        <form action="uploadProfilePic.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profile_pic" class="custom-file-input" id="customFile">
            <label class="profile-picture-label" for="customFile">
                <img id="profilePicture" src="images/profileImages/profile0.png?<?php echo mt_rand(); ?>" class="profile-picture" alt="Profile Picture">
            </label>
            <h2 class="profile-name"><?php echo $_SESSION['Name']; ?></h2>
            <h4 class="profile-username"><?php echo $_SESSION['Username']; ?></h4>
            <div class="profile-info">
                <p><strong>Email ID:</strong> <?php echo $_SESSION['Email']; ?></p>
                <p><strong>ADDRESS:</strong> <?php echo $_SESSION['Addr']; ?></p>
                <p><strong>Mobile No:</strong> <?php echo $_SESSION['Mobile']; ?></p>
                <p><strong>Rating:</strong> <?php echo $totalRating; ?></p>
            </div>
            <div class="btn-group">
                <a href="changePassPage.php" class="btn btn-danger">Change Password</a>
                <a href="uploadProduct.php" class="btn btn-danger">Upload Product</a>
                <a href="profileEditPage.php" class="btn btn-danger">Edit Profile</a>
            </div>
            <a href="Login/logout.php" class="btn btn-danger">LOG OUT</a>
        </form>
    </div>
</div>

</body>
</html>
