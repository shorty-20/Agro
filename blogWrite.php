<!DOCTYPE HTML>
<html>
<head>
    <title>Agri-Business: Write a Blog</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<?php
session_start();
require 'menu.php';
?>

<form method="post" action="Blog/blogSubmit.php">
    <section id="main" class="wrapper">
        <div class="inner">
            <div class="container">
                <div class="box">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <h2 class="text-center">Write a Review</h2>
                            <div class="form-group">
                                <input type="text" class="form-control" name="blogTitle" id="blogTitle" placeholder="Blog Title" required/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="blogContent" id="blogContent" rows="8" placeholder="Blog Description"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
