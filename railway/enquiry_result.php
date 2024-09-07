<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f0f0; /* Set your desired background color here */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        table {
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
        form {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 200px;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php 

session_start();

require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if 'doj' is set in the POST data
    if (isset($_POST['doj']) && !empty($_POST['doj'])) {
        $_SESSION['doj'] = $_POST['doj'];
    } else {
        // Redirect back to the enquiry page if 'doj' is not set
        header("Location: enquiry.php");
        exit;
    }
}
$sp=$_POST["sp"];
$_SESSION["sp"] = "$sp";
$dp=$_POST["dp"];
$_SESSION["dp"] = "$dp";

$query = mysqli_query($conn,"SELECT t.trainno,t.tname,c.sp,s1.departure_time,c.dp,s2.arrival_time,t.dd,c.class,c.fare,c.seatsleft FROM train as t,classseats as c, schedule as s1,schedule as s2 where s1.trainno=t.trainno AND s2.trainno=t.trainno AND s1.sname='".$sp."' AND s2.sname='".$dp."' AND t.trainno=c.trainno AND c.sp='".$sp."' AND c.dp='".$dp."' ");

echo "<table><thead><td>Train No</td><td>Train_Name</td><td>Starting_Point</td><td>Arrival_Time</td><td>Destination_Point</td><td>Departure_Time</td><td>Day</td><td>Train_Class</td><td>Fare</td><td>Seats_Left</td></thead>";

while($row = mysqli_fetch_array($query))
{
 echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td><td>".$row[9]."</td></tr>";
}
echo "</table>";

//$rowcount=mysqli_num_rows($query);
if(mysqli_num_rows($query) == 0)
{
 echo "No such train <br> ";

}
?>
<br><br>
If you wish to proceed with booking, fill in the following details:<br><br>
<form action="resvn.php" method="post">
    Email Id: <input type="text" name="emailid" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Enter Train No: <input type="text" name="tno" required><br><br>
    Enter Class: <input type="text" name="class" required><br><br>
    No. of Seats: <input type="text" name="nos" required><br><br>
    <input type="submit" value="Proceed with Booking"><br><br>
</form>

<a href="http://localhost/railway/enquiry.php">More Enquiry</a><br>

<a href="http://localhost/railway/index.htm">Go to Home Page!!!</a>
</body>
</html>
