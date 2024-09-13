<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile: <?php echo $_SESSION['Username']; ?></title>
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f3f4f6;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .box-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .box-header h2, .box-header h4 {
            margin: 0;
            color: #333;
        }
        .profile-pic {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-upload {
            margin-top: 10px;
        }
        /* New CSS for menu bar */
        .menu {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .menu li {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
    <script>
        function validateForm() {
            // Custom validation logic can be added here if needed
            return true;
        }
    </script>
</head>
<body>

<!-- Menu bar -->
<ul class="menu">
<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
<li><a href="myCart.php"><span class="glyphicon glyphicon-shopping-cart"> MyCart</a></li>
<li><a href="<?= $link; ?>"><span class="<?php echo $logo; ?>"></span><?php echo" ". $loginProfile; ?></a></li>
<li><a href="market.php"><span class="glyphicon glyphicon-grain"> Digital-Market</a></li>
<li><a href="blogView.php"><span class="glyphicon glyphicon-comment"> BLOG</a></li>
</ul>

<section id="post" class="wrapper bg-img" data-bg="banner2.jpg">
    <div class="container">
        <div class="box">
            <header class="box-header">
            <label class="profile-picture-label" for="customFile">
                <img id="profilePicture" src="images/profileImages/profile0.png?<?php echo mt_rand(); ?>" class="profile-picture" alt="Profile Picture">
            </label>                
        
                <h2><?php echo $_SESSION['Name'];?></h2>
                <h4><?php echo $_SESSION['Username'];?></h4>
            </header>
            <!-- Rest of the form content -->
            <form method="post" action="profileEdit.php" onsubmit="return validateForm()">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter the name" />
    </div>
    <div class="form-group">
        <label for="mobile">Mobile No</label>
        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter the mobile" />
    </div>
    <div class="form-group">
        <label for="uname">Username</label>
        <input type="text" name="uname" id="uname" class="form-control" placeholder="Enter the Username" />
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter the email" />
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" class="form-control" placeholder="Enter the address" />
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
    </div>
</form>

        </div>
    </div>
</section>
</body>
</html>
