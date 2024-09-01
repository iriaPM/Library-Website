<?php
require_once "DBconn.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    // Redirect to login page 
    header("Location: login.php");
    exit();
}

// Fetch the username from the session
$username = $_SESSION["Username"];
$pagnum = isset($_GET['pagnum']) ? (int)$_GET['pagnum'] : 0;
$offset = $pagnum * 5;
//select all the info from the books and check if they are reserved Y or not N 
$sql = "SELECT
        ISBN, 
        BookTitle AS 'Title',
        Author,
        CategoryDescrip AS 'Category',
        CASE WHEN IsReserved = 'Y' THEN 'Yes' ELSE 'No' END AS 'Reserved'
        FROM
        books
        JOIN
        categories ON books.CategoryID = categories.CategoryID
        LIMIT 5 OFFSET $offset;";

$result = $conn->query($sql);

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
                <li><a href="myaccount.php">MyAccount</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div>
    </header>
    <br><br><br>
    <div>
        <table class="tablereservations">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>   ISBN   </th>
                <th>Category</th>
                <th>Available</th>
                <th>Add to your collection</th>
            </tr>
            <?php
                //while loop to display all the books       
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo (htmlentities($row["Title"]));
                        echo ("</td><td>");
                        echo (htmlentities($row["Author"]));
                        echo ("</td><td>");
                        echo (htmlentities($row["ISBN"]));
                        echo ("</td><td>");
                        echo (htmlentities($row["Category"]));
                        echo ("</td><td>");
                        echo (htmlentities($row["Reserved"]));
                        echo ("</td><td>");
                        echo ('<a href="reserve.php?isbn='.htmlentities($row["ISBN"]).'">Reserve</a> ');  
                        echo '</form>';
                        echo "</td></tr>\n";
                } }else {
                    echo "0 results";
                }
            ?>
            
        </table>
        <div class="pagination">
            <?php
            if ($result->num_rows > 0) {
                if ($pagnum > 0) {
                    echo "<a href='?pagnum=" . ($pagnum - 1) . "'>Previous Page</a>";
                }
                echo " | ";
                echo "<a href='?pagnum=" . ($pagnum + 1) . "'>Next Page</a>";
            }
            ?>
        </div>
    </div>
    <br><br><br><br><br><br>
    <footer class="footer">

    <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
         All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
    </footer>
</body>

</html>