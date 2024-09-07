<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Result</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            font-size: 18px;
        }

        h2 {
            color: black;
        }

        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <div id="registration-result">
        <?php
            require "db.php";

            $pwd = $_POST["password"];
            $eid = $_POST["emailid"];
            $mno = $_POST["mobileno"];
            $dob = $_POST["dob"];

            // Use prepared statements to prevent SQL injection
            $sql = "INSERT INTO user (password, emailid, mobileno, dob) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $pwd, $eid, $mno, $dob);

            if ($stmt->execute()) {
                echo "<h2>Hi $eid,</h2>";
                echo "<p>Registration successful! <br> <a href=\"http://localhost/railway/index.htm\">Click here</a> to browse through our website.</p>";
            } else {
                echo "<h2>Error:</h2>";
                echo "<p>" . $conn->error . "</p>";
                echo "<p><a href=\"http://localhost/railway/new_user_form.htm\">Go Back to Login</a></p>";
            }

            $stmt->close();
            $conn->close();
        ?>
    </div>
</body>
</html>
                                                                                                                        