<?php
session_start();
require_once "DBconn.php";

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    // Redirect to login page 
    header("Location: login.php");
    exit();
}
// Fetch the username from the session
$username = $_SESSION["Username"];

// Get ISBN from the URL 
$isbn = $_GET['isbn'];

// Check if the book is already reserved
$reservationCheckSql = "SELECT * FROM reservations WHERE ISBN = '$isbn' AND Username = '$username';";
$reservationCheckResult = $conn->query($reservationCheckSql);

if ($reservationCheckResult->num_rows > 0) {
    echo "<p class='response'>Error: The book is already reserved by you.<p/>";
} else {
    // Reserve book
    $reservationSql = "INSERT INTO reservations (ISBN, Username, ReservedDate) VALUES ('$isbn', '$username', CURDATE());";
    $reservationResult = $conn->query($reservationSql);

    if (!$reservationResult) {
        echo "Error: " . $conn->error;
    } else {
        echo "<p class='response'>Book reserved successfully!<p/>";
    }
}
?>
<!DOCTYPE html>
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
                <li><a href="myaccount.php">MyAccount</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div>
    </header>
   <br><br><br>
       


    <br><br><br><br>
    <footer class="footer">

        
        <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
            All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
           
    </footer>
</body>
</html>