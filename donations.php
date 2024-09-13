<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donations History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: #6ea8ff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>We Thank You For Your donations</h1>
        <br>
        <h1>Donation History</h1>

        <table>
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Doner Name</th>
                    <th>Recipient Name</th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Product Info</th>
                    <th>Product Quantity</th>
                    <th>Product Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                // Fetch data from the transaction table and display it in rows
                require 'db.php';
                $sql = "SELECT * FROM `donate_table`";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $pid = $row['pid'];
                        $sqln1 = "SELECT * FROM `fproduct` WHERE `pid`='$pid'";
                        $resultn1 = $conn->query($sqln1);
                        $rown1 = mysqli_fetch_assoc($resultn1);
                        $fid = $rown1['fid'];
                        $sqln = "SELECT * FROM `farmer` WHERE `fid`='$fid'";
                        $resultn = $conn->query($sqln);
                        $rown = mysqli_fetch_assoc($resultn);
                        $doner_name = $rown['fname'];
                        echo "<tr>";
                        echo "<td>" . $row['did'] . "</td>";
                        echo "<td>" . $row['donatedto'] . "</td>";
                        echo "<td>" . $doner_name . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['info'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="./Login/profile.php" class="btn">Back to Home</a>
    </div>
</body>

</html>
