<?php
require_once "DBconn.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    // Redirect to login page 
    header("Location: login.php");
    exit();
}

// fetch the username from the session
$username = $_SESSION["Username"];

//select title,isbn,author,and category from the books the user has reserved 
$sql = "SELECT c.CategoryDescrip, b.BookTitle, b.Author, b.ISBN
        FROM 
        reservations r
        JOIN 
        books b ON r.ISBN = b.ISBN
        JOIN 
        categories c ON b.CategoryID = c.CategoryID
        WHERE 
        r.Username = '$username'";

$result = $conn->query($sql);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </div>
    </header>
    <br><br><br>
    <div>
        <table class="tablereservations">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Remove</th>
            </tr>
                                       
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo htmlentities($row["BookTitle"]); ?></td>
                            <td><?php echo htmlentities($row["Author"]); ?></td>
                            <td><?php echo htmlentities($row["ISBN"]); ?></td>
                            <td><?php echo htmlentities($row["CategoryDescrip"]); ?></td>
                            
                            <td>
                            <form action="delete.php" method="post">
                                <input type="hidden" name="ISBN" value="<?php echo htmlentities($row["ISBN"]); ?>">
                                <button id="removebutton" type="submit">Remove</button>
                            </form>
                            </td>

                        </tr>
                <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
            <tr>
                <th><a href="displaybooks.php">Add new book</a></th>
            </tr>
        </table>
    </div>
    
    <footer class="footer">
    <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
         All images/videos are from <a href="https://images.google.com/">Google Images</a></p> 
    </footer>
</body>

</html>