<?php
session_start(); //start a session with user 
require_once "DBconn.php";//connect with database 
echo("<link rel='stylesheet' type='css' href='css/style.css'>");//link with css
unset($_SESSION["Username"]);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" type="text/css" href="css\style.css">
</head>

<body style="background-image: url('images/background1.jpg');">

    <header>

        <div id="logo">
            <a href="index.html"><img src="images/TUD_White.png"></a>
        </div>
        <div id="title">
            <a href="index.html">
                <h1>Library</h1>
            </a>
        </div>
        <div>
            <ul class="navbar">
                <li><a href="displaybooks.php">Reserve a book</a></li>
                <li><a href="login.php">MyAccount</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div>
    </header>
    <div>
    <br><br>
            
            <form method="post"  id="login" class="formone">
            <p >Username: <br><input type="text" name="Username" value=""></p>
            <p >Password:<br> <input type="password" name="Password" value=""></p>
            <p ><input type="submit" value="Log In"></p>
            </form>
            <?php
                //details need to match with info from the databse 
                if (isset($_POST["Username"]) && isset($_POST["Password"])) 
                {
                    $username = $_POST["Username"];
                    $password = $_POST["Password"];

                    $sql = "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) 
                    {
                        // Fetch the user's ID
                        $row = $result->fetch_assoc();
                        $username = $row['Username'];

                        // Store the user's ID in the session
                        $_SESSION["Username"] = $username;
                        $_SESSION["Password"] = $password;
                        $_SESSION["success"] = "Logged in.";
                        header('Location: myaccount.php');
                        return;
                    } else 
                    {
                        $_SESSION["error"] = "Incorrect username or password.";
                        header('Location: login.php');
                        return;
                    }
                } elseif (count($_POST) > 0) 
                {
                    $_SESSION["error"] = "Missing Required Information";
                    header('Location: login.php');
                    return;
                }
                
            if ( isset($_SESSION["error"]) ) {
            echo('<p class="formerror" >Error:'.
            $_SESSION["error"]."</p>\n");
            unset($_SESSION["error"]);
            }
        ?>
    </div>

    <br><br><br><br><br><br><br><br>
   
    <footer class="footer">

        <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
         All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
        
    </footer>
</body>

</html>