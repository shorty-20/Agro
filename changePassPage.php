<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Change Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gradient background */
        body {
            background: linear-gradient(120deg, #87CEEB, #4682B4);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function validateForm() {
            var currentPassword = document.getElementById("current_password").value;
            var newPassword = document.getElementById("new_password").value;
            var confirmNewPassword = document.getElementById("confirm_new_password").value;

            if (newPassword === currentPassword) {
                alert("New password cannot be the same as the current password.");
                return false;
            }

            if (newPassword !== confirmNewPassword) {
                alert("New password and confirm password do not match.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<?php
session_start(); 
require 'menu.php'; 
?>
<div class="container">
    <div class="card">
        <h2>Change Password</h2>
        <form method="post" action="changePass.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" required>
            </div>
            <!-- Change the button type to submit -->
            <input type="submit" value="Change Password">
        </form>
    </div>
</div>

</body>
</html>
