<?php
	session_start();
	$commentId = $_SESSION['id'];
	require 'db.php';

	if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] == 0)
	{
		$_SESSION['message'] = "You need to first login to access this page !!!";
		header("Location: Login/error.php");
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == 1)
	{
		if(isset($_POST['comment']) AND $_POST['comment'] != "")
		{
			$sql = "SELECT * FROM blogdata ORDER BY blogId DESC";
			$result = mysqli_query($conn, $sql);

			while($row = $result->fetch_array())
			{
				$check = "submit".$row['blogId'];
				if(isset($_POST[$check]))
				{
					$blogId = $row['blogId'];
					break;
	 			}
			}

			$comment = dataFilter($_POST['comment']);
			if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == 1)
			{
				$commentUser = $_SESSION['Username'];
				$pic = $_SESSION['picName'];
			}
			else {
				$commentUser = "Anonymous";
				$pic = "profile0.png";
			}
			if(isset($blogId))
			{
				$sql = "INSERT INTO blogfeedback (commentId, blogId, comment, commentUser)
						VALUES ('$commentId', '$blogId' ,'$comment', '$commentUser');";
				$result = mysqli_query($conn, $sql);
			}
		}

		else
		{
			$sql = "SELECT * FROM blogdata ORDER BY blogId DESC";
			$result = mysqli_query($conn, $sql);

			while($row = $result->fetch_array())
			{
				$check = "like".$row['blogId'];
				if(isset($_POST[$check]))
				{
					$blogId = $row['blogId'];
					break;
				}
			}
			$likeCheck = "isLiked".$blogId;
			if(!isset($_SESSION[$likeCheck]) OR $_SESSION[$likeCheck] == 0)
			{
				$id = $_SESSION['id'];
				$sql = "SELECT * FROM likedata WHERE blogId = '$blogId' AND blogUserId = '$id'";
				$result = mysqli_query($conn, $sql);
				$num_rows = mysqli_num_rows($result);
				if($num_rows == 0)
				{
					$sql = "INSERT INTO likedata (blogId, blogUserId)
							VALUES('$blogId', '$id')";
					$result = mysqli_query($conn, $sql);
					$sql = "UPDATE blogdata SET likes = likes + 1 WHERE blogId = '$blogId'";
					$result = mysqli_query($conn, $sql);
					$_SESSION[$likeCheck] = 1;
				}
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

	$sql = "SELECT * FROM blogdata ORDER BY blogId DESC";
	$result = mysqli_query($conn, $sql);

	function formatDate($date)
	{
		return date('g:i a', strtotime($date));
	}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Agri-Business: Blogs</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Blog/commentBox.css" />
</head>
<body class="subpage">
    <?php require 'menu.php'; ?>
    <section id="main" class="wrapper">
        <div class="inner">
            <div class="container" style="width: 70%">
                <div class="row uniform">
                    <div class="9u 12u$(small)">
                        <!-- Content Here -->
                    </div>
                    <div class="3u 12u$(small)">
                        <a href="blogWrite.php" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-pencil"></span> Write a Review</a>
                    </div>
                </div>
                <br />
                <?php
                while($row = $result->fetch_array()) :
                    $id = $row['blogId'];
                    $sql = "SELECT * FROM blogfeedback WHERE blogId = '$id'";
                    $result1 = mysqli_query($conn, $sql);
                    $numComment = mysqli_num_rows($result1);
                ?>
                <div class="box">
                    <h2><?= $row['blogTitle']; ?></h2>
                    <blockquote>
                        <?= $row['blogContent']; ?>
                        <p>--- <?= $row['blogUser']; ?></p>
                        <p><?= $row['blogTime']; ?></p>
                    </blockquote>
                    <form method="post" action="blogView.php">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-success btn-sm" name="<?php echo 'like'.$id; ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like <span class="badge"><?= $row['likes']?></span></button>
                            </div>
                            <div class="col-md-6">
                                <span class="glyphicon glyphicon-pencil"></span> Comments : <?= $numComment ?>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <textarea name="comment" id="comment" rows="1" placeholder="Write a Comment!" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <input type="submit" name="<?php echo 'submit'.$id; ?>" class="btn btn-primary btn-sm" value="Submit"/>
                            </div>
                        </div>
                    </form>
                    <?php if($result1) : ?>
                        <?php while($row1 = $result1->fetch_array()) : ?>
                            <div class="con darker">
                                <br>
                                <?= $row1['comment']; ?>
                                <span class="time-right"><?= formatDate($row1['commentTime']); ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <script src="jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
