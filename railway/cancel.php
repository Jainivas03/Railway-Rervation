<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: #f0f0f0; /* Set your desired background color */
            font-family: Arial, sans-serif;
            text-align: center;
            color: #333;
        }

        .container {
            background-color: #fff; /* Background color for the content container */
            border-radius: 10px;
            padding: 20px;
            margin: 100px auto;
            max-width: 400px;
        }

        h2 {
            color: #007BFF;
        }

        .message {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Railway Ticket Cancellation</h2>

        <?php
        session_start();
        require "db.php";

        $cancpnr=$_POST["pnr"];

        //echo "$uid";
        
        $sql=" UPDATE resv SET status ='CANCELLED' WHERE resv.pnr='".$cancpnr."' ";
        
        if ($conn->query($sql) === TRUE) 
        {
         echo "Cancellation Successful!!!";
        } 
        else 
        {
         echo "<br><br>Error:" . $conn->error;
        }
        
        echo " <br><br><a href=\"http://localhost/railway/index.htm\">Home Page</a><br>";
        

        $conn->close();
        ?>
    </div>
</body>

</html>
