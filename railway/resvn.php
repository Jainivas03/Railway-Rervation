<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #e93b5b; /* Set your desired background color here */
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
        h2{
            color: black;
            font-size: 24px;
            margin-bottom: 0;
            font-weight: bold;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 0;
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
            background-color: #fa2803;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #a62008;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <form action="new_png.php" method="post">
        <h2>Passenger Information</h2>
        <?php
        session_start();
        require "db.php";

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $eid = isset($_POST["emailid"]) ? $_POST["emailid"] : '';
        $pwd = isset($_POST["password"]) ? $_POST["password"] : ''; // Ensure you check if the password is set

        if (empty($eid) || empty($pwd)) {
            echo "<p style='color: red;'>Email ID and password are required. Please fill in both and try again.</p>";
        } else {

            $query = "SELECT * FROM user WHERE user.emailid='$eid' AND user.password='".$pwd."' ";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

            if (mysqli_num_rows($result) == 0) {
                echo "<p style='color: red;'>No such login. Please try again.</p>";
                echo " <br><a href=\"http://localhost/railway/enquiry_result.php\">Go Back</a> <br>";
                die();
            }

            $row = mysqli_fetch_array($result);
            $temp = $row['id'];
            $_SESSION["id"] = $temp;
            $tno = $_POST["tno"];
            $_SESSION["tno"] = $tno;
            $class = $_POST["class"];
            $_SESSION["class"] = $class;
            $nos = $_POST["nos"];
            $_SESSION["nos"] = $nos;

            echo "<table>";

            for ($i = 0; $i < $nos; $i++) {
                echo "<tr><td><input type='text' name='pname[]' placeholder=\"Passenger Name\" required></td><br> ";
                echo "<td><input type='text' name='page[]' placeholder=\"Passenger Age\" required></td><br>";
                echo "<td><input type='text' name='pgender[]' placeholder=\"Passenger Gender\" required></td></tr><br> ";
            }

            echo "</table>";

            $conn->close();
        }
        ?>
        <br><br>
        <input type="submit" value="Book">
    </form>
    <a href="http://localhost/railway/enquiry.php">Back to Enquiry</a>
</div>
</body>
</html>
