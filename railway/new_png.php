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
            max-width: 600px;
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
            width: 100%;
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
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>


<?php
session_start();
require "db.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pname = $_POST["pname"];
$page = $_POST["page"];
$pgender = $_POST["pgender"];

$tno = isset($_SESSION["tno"]) ? $_SESSION["tno"] : null;
$doj = isset($_SESSION["doj"]) ? $_SESSION["doj"] : null;
$sp = isset($_SESSION["sp"]) ? $_SESSION["sp"] : null;
$dp = isset($_SESSION["dp"]) ? $_SESSION["dp"] : null;
$class = isset($_SESSION["class"]) ? $_SESSION["class"] : null;
//echo $tno, $doj, $sp, $dp, $class;
if ($tno === null || $doj === null || $sp === null || $dp === null || $class === null) {
    echo "Session data is missing. Please go back and fill in the required information.";
    die();
}

$query = "SELECT fare FROM classseats WHERE trainno='$tno' AND class='$class' AND sp='$sp' AND dp='$dp'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$row = mysqli_fetch_array($result);
$fare = $row[0];

$tempfare = 0;
$temp = 0;

for ($i = 0; $i < count($pname); $i++) {
    if ($page[$i] >= 18) {
        $temp++;
        $tempfare += $fare;
    } elseif ($page[$i] < 18) {
        $tempfare += 0.5 * $fare;
    } elseif ($page[$i] >= 60) {
        $tempfare += 0.5 * $fare;
    }
    
    // Validate gender input
    if ($pgender[$i] !== 'M' && $pgender[$i] !== 'F') {
        echo "Invalid gender input. Enter 'M' for Male or 'F' for Female.";
        die();
    }
}

if ($temp == 0) {
    echo "<br><br>At least one adult must accompany!!!";
    echo "<br><br><a href=\"http://localhost/railway/enquiry.php\">Back to Enquiry</a> <br>";
    die();
}

echo "Total fare is Rs." . $tempfare . "/-";

$sql = "INSERT INTO resv (id, trainno, sp, dp, doj, tfare, class, nos) VALUES ('" . $_SESSION["id"] . "', '$tno', '$sp', '$dp', '$doj', '$tempfare', '$class', '" . count($pname) . "' )";

if ($conn->query($sql) === TRUE) {
    echo "<br><br>Reservation Successful";
} else {
    echo "<br><br>Error: " . $conn->error;
}

$tid = $_SESSION["id"];
$ttno = $tno;

$query = "SELECT pnr FROM resv WHERE id='$tid' AND trainno='$ttno'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$row = mysqli_fetch_array($result);
$rpnr = $row['pnr'];

$tpname = $_POST['pname'];
$tpage = $_POST["page"];
$tpgender = $_POST["pgender"];

for ($i = 0; $i < count($tpname); $i++) {
    $sql = "INSERT INTO pd (pnr, pname, page, pgender) VALUES ('$rpnr', '{$tpname[$i]}', '{$tpage[$i]}', '{$tpgender[$i]}')";

    if ($conn->query($sql) === TRUE) {
        echo "<br><br>Passenger details added!!!";
    } else {
        echo "<br><br>Error: " . $conn->error;
    }
}

echo "<br><br><a href=\"http://localhost/railway/index.htm\">Go Back!!!</a> <br>";

$conn->close();
?>

