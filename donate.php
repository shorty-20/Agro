<?php
    session_start();
    require 'db.php';
    $pid = $_GET['pid'];

    $ngo_names = array(); // Initialize an array to store NGO names

    $sql = "SELECT * FROM ngo";
    $result = mysqli_query($conn, $sql);
    while ($row = $result->fetch_assoc()){
        $ngo_names[] = $row['ngoname']; // Add each NGO name to the array
    }
    $sqln="SELECT * FROM fproduct WHERE pid = '$pid'";
    $result = mysqli_query($conn, $sqln);
    $row = mysqli_fetch_assoc($result);
    $maxquantity = $row['quantity'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Names Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select,
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Donation Form</h2>
        <form method="POST" action="process_donation.php?pid=<?php echo $pid; ?>">
            <label for="ngo">NGO:</label>
            <select name="ngo" id="ngo">
                <?php
                    foreach ($ngo_names as $ngo_name) {
                        echo "<option value=\"$ngo_name\">$ngo_name</option>";
                    }
                ?>
            </select>
            <label for="addedquantity">Quantity:</label>
            <input type="number" id="addedquantity" name="addedquantity" min="1" max="<?php echo $maxquantity; ?>" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
