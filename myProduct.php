<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agri-Business</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body {
            background: linear-gradient(135deg, #ffffff, #f2f2f2);
        }

        #welcome-header {
            margin-top: 300px; /* Add some margin to create distance from the cards */
            margin-bottom: 160px; /* Add some margin to create distance from the cards */
            text-align: center; /* Center align the text */
            font-size: 60px; /* Adjust the font size as needed */
        }

        #main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .card:hover {
			transform: translateY(-5px);
			box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.2);
		}
    </style>
</head>
<body style="background: linear-gradient(135deg, #ffffff, #f2f2f2);">

<?php
    session_start();
    require 'menu.php';
    $farmerid = $_SESSION['id'];
?>
<?php
    
    // Fetch products from the database
    require 'db.php';
    if(!isset($_GET['type']) OR $_GET['type'] == "all")
    {
        $sql = "SELECT * FROM fproduct WHERE fid = '$farmerid' AND quantity > 0";
    }
    elseif(isset($_GET['type']) AND $_GET['type'] == "fruit")
    {
        $sql = "SELECT * FROM fproduct WHERE pcat = 'Fruit'";
    }
    elseif(isset($_GET['type']) AND $_GET['type'] == "vegetable")
    {
        $sql = "SELECT * FROM fproduct WHERE pcat = 'Vegetable'";
    }
    elseif(isset($_GET['type']) AND $_GET['type'] == "grain")
    {
        $sql = "SELECT * FROM fproduct WHERE pcat = 'Grains'";
    }
    $result = mysqli_query($conn, $sql);
?>

<section id="main" class="wrapper style1 align-center">
    <div class="container">
        <h1 id="welcome-header">Welcome to digital market</h1>
        <?php if (isset($_GET['n']) && $_GET['n'] == 1) { ?>
            <h3>Select Filter</h3>
            <form method="GET" action="myProduct.php?">
                <input type="text" value="1" name="n" style="display: none;"/>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <select name="type" id="type" class="form-control" required>
                                <option value="all">List All</option>
                                <option value="fruit">Fruit</option>
                                <option value="vegetable">Vegetable</option>
                                <option value="grain">Grains</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4">
                        <button type="submit" class="btn btn-primary btn-block">Go!</button>
                    </div>
                </div>
            </form>
        <?php } ?>
        <section id="two" class="wrapper style2 align-center">
            <div class="container">
                <div class="row">
                    <?php while($row = $result->fetch_array()): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" src="images/productImages/<?php echo $row['pimage']; ?>" alt="<?php echo $row['product']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['product']; ?></h5>
                                    <p class="card-text">Type: <?php echo $row['pcat']; ?></p>
                                    <p class="card-text">Price: <?php echo $row['price']; ?> /-</p>
                                    <p class="card-text">Quantity: <?php echo $row['quantity']; ?></p>
                                    <a href="freview.php?pid=<?php echo $row['pid']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



