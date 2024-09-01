<?php
 require_once "DBconn.php";
 //select details from the databse 
 $query = $conn->query("SELECT CategoryID, CategoryDescrip FROM categories");

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
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </header>
    <div id="content">
        <h3>Is there a specific book that you want? </h3>
    </div>
    
    <form action="searchbook.php" method="GET" id="login" class="formone">
            <p>Title:<br><input type="text" name="Title" ></p>
            <p>Author:<br> <input type="text" name="Author"></p>
            <p>Category:<br>
            <?php
            echo "<select name='Category'>";
            echo '<option value="">Select Category</option>'; 
            //display the categories from the database
            while ($row = $query->fetch_assoc()) {
                $Catid = $row['CategoryID'];
                $selectoption = $row['CategoryDescrip'];
                echo '<option value="' . $Catid . '">' . $selectoption . '</option>';
            }
            echo "</select><br>";
            ?>
            </p>
        <input type="submit" value="Submit"> 
    </form>
        <footer class="footer">
        <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
            All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
    </footer>
</body>
</html>