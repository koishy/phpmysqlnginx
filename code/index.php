<?php 
$names = ["Ferrari", "iPhone XS", "Particles Accelerator"];
$images = ["./ferrari.jpeg", "./xs.jpeg", "./pac.jpeg"];
$item = rand(0, 2);

//init database if not exist
$dbinit = new mysqli("172.18.0.2", "root", "password");
$dbinit->query("CREATE DATABASE IF NOT EXISTS myDB");
$dbinit->close();
$dbinit = new mysqli("172.18.0.2", "root", "password", "myDB");
$_res = $dbinit->query("SHOW TABLES LIKE 'users';");

if ($_res->num_rows == 0)
{
    $dbinit->query("CREATE TABLE `users` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(256) NOT NULL,
        `money` int NOT NULL
      ) ENGINE='MyISAM' COLLATE 'utf8_bin';");
}
$dbinit->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        tr td
        {
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            padding: 10px 20px;
        }

        table
        {
            border-collapse: collapse;
        }
        table tr:last-child td
        {
            border-bottom: none;
        }

        table tr td:last-child
        {
            border-right: none;
        }
    </style>
</head>
<body>
    <form action="/" method="POST">
        <label for="name">Your name: </label>
        <input type="text" id="name" name="name">
        <label for="money">Your balance: </label>
        <input type="number" id="money" name="money">
        <input type="submit" value="Submit">
    </form>
    <?php

        $db = new mysqli("172.18.0.2", "root", "password", "myDB");

        if ($db->connect_error)
        {
            die("Connection Failed");
        }
        
        if (isset($_POST["name"], $_POST["money"]))
        {
            $sql = "INSERT INTO users (username, money) VALUES ('".$_POST["name"]."', ".$_POST["money"].")";
            $db->query($sql);
        }

        $_res = $db->query("SELECT * FROM users ORDER BY id");

        if ($_res->num_rows > 0) {
            // output data of each row
            echo "<table>";
            echo "<tr><td>id</td><td>username</td><td>money</td></tr>";
            while($row = $_res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"]. "</td><td>" . $row["username"]. "</td><td>" . $row["money"]. "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }


        $db->close();


    ?>

</body>
</html>