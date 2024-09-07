<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #e93b5b; 
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-top: 100px;            
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        select, input {
            width: 400px;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #fa2803;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            margin-left: 80px
        }
        input[type="submit"]:hover {
            background-color: #a62008;
        }
    </style>
</head>
<body>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['doj'])) {
    // Initialize the session and set the variables
    $_SESSION['doj'] = $_POST['doj'];
}
?>

<div class="container">
    <form action="enquiry_result.php" method="post">
        <label for="sp">Starting Point:</label>
        <select id="sp" name="sp" required>
            <?php
            require "db.php";
            $cdquery = "SELECT sname FROM station";
            $cdresult = mysqli_query($conn, $cdquery);
            echo "<option value=''></option>";
            while ($cdrow = mysqli_fetch_array($cdresult)) {
                $cdTitle = $cdrow['sname'];
                echo "<option value='$cdTitle'>$cdTitle</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="dp">Destination Point:</label>
        <select id="dp" name="dp" required>
            <?php
            require "db.php";
            $cdquery = "SELECT sname FROM station";
            $cdresult = mysqli_query($conn, $cdquery);
            echo "<option value=''></option>";
            while ($cdrow = mysqli_fetch_array($cdresult)) {
                $cdTitle = $cdrow['sname'];
                echo "<option value='$cdTitle'>$cdTitle</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="doj">Date of Journey:</label>
        <input type="date" id="doj" name="doj" required>
        <br>
        <input type="submit" value="Submit">
    </form>
    <br><br>
    <a href="http://localhost/railway/index.htm">Go to Home Page!!!</a>
</div>
</body>
</html>
