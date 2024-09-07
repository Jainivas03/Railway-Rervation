<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f0f0; /* Set your desired background color here */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
<?php 
session_start();
require "db.php";

if ($conn->connect_error) 
{
 die("Connection failed: " . $conn->connect_error);
} 

$eid = $_POST["emailid"];
$pwd = $_POST["password"];

$query = mysqli_query($conn, "SELECT id, emailid FROM user WHERE emailid = '$eid' AND password = '$pwd'") or die(mysqli_error($conn));

if ($row = mysqli_fetch_array($query)) {
    $_SESSION["pnr"] = $row['pnr']; // Set 'id' in the session
    echo "Welcome " . $row['emailid'];

    $query2 = mysqli_query($conn, "SELECT * FROM user, resv WHERE user.id = resv.id AND user.emailid = '$eid'") or die(mysqli_error($conn));

    echo "<table><thead><td>PNR</td><td>Train_no</td><td>Date_Of_Journey</td><td>Total_Fare</td><td>Train_Class</td><td>Seats_Reserved</td><td>Status</td></thead>";

    while($row = mysqli_fetch_array($query2))
    {
        echo "<tr><td>".$row["pnr"]."</td><td>".$row["trainno"]."</td><td>".$row["doj"]."</td><td>".$row["tfare"]."</td><td>".$row["class"]."</td><td>".$row["nos"]."</td><td>".$row["status"]."</td></tr>";
    }

    echo "</table>";

    if(mysqli_num_rows($query2) == 0)
    {
        echo "No Reservations Yet !!! <br><br> ";
    }
} else {
    echo "Wrong Combination!!! <br><br> ";
    echo " <a href=\"http://localhost/railway/index.htm\">Home Page</a><br>";
    die();
}

?>
<form action="cancel.php" method="post">
    Enter PNR for Cancellation: <input type="text" name="cancpnr" required><br><br>
    <input type="submit" value="Cancel"><br><br>
</form>
<?php

echo " <a href=\"http://localhost/railway/index.htm\">Home Page</a><br>";

$conn->close(); 

?>
</body>
</html>
