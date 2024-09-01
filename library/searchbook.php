<?php
require_once "DBconn.php"; //connect with database
session_start();//start a session with user 
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

// Fetch the username from the session
$username = $_SESSION["Username"];

function generateSearchQuery() {
    $searchConditions = [];

    if (!empty($_GET["Author"])) {
        $searchConditions[] = sprintf("LOWER(Author) = LOWER('%s')", $_GET["Author"]);
    }

    if (!empty($_GET["Category"])) {
        $searchConditions[] = sprintf("books.CategoryID = %d", $_GET["Category"]);
    }

    if (!empty($_GET["Title"])) {
        $searchConditions[] = sprintf("LOWER(BookTitle) = LOWER('%s')", $_GET["Title"]);
    }

    // join conditions with OR
    $searchQuery = implode(" OR ", $searchConditions);

    $pagnum = isset($_GET['pagnum']) ? (int)$_GET['pagnum'] : 0;
    $offset = $pagnum * 5;

    //make 5 rows of a table with the books info
    $searchQuery = "SELECT ISBN, BookTitle AS 'Title', Author, CategoryDescrip AS 'Category', 
        CASE WHEN IsReserved = 'Y' THEN 'Yes' ELSE 'No' END AS 'Reserved' 
        FROM books 
        JOIN categories ON books.CategoryID = categories.CategoryID 
        WHERE $searchQuery 
        LIMIT 5 OFFSET $offset";
    
    return $searchQuery;
}
//generate the URL  for pagination links
function generatePaginationURL($pagnum) {
    $urlParams = http_build_query(array_merge($_GET, ["pagnum" => $pagnum]));
    return "searchbook.php?" . $urlParams;
}

$searchQuery = generateSearchQuery();

//error checking for searchbar, the form accepts at least one input, either author, or category or title or all 
if (!empty($_GET["Author"]) || !empty($_GET["Category"]) || !empty($_GET["Title"])) {
    $searchQuery = generateSearchQuery();

    // Check if is not empty
    if (!empty($searchQuery)) {
        $result = $conn->query($searchQuery);

        // Check if the result is not empty 
        if ($result === false) {
            echo "Error: Database query error.";
            header("refresh:2;url=searchbar.php");
            exit();
        }
    } else {
        echo "Error: Empty query.";
        header("refresh:2;url=searchbar.php");
        exit();
    }
} else {
    echo "Error: Please provide at least one search criteria.";
    exit();
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
                <li><a href="logout.php">Log Out</a></li>
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
                <th>Available</th>
                <th>Add to your collection</th>
            </tr>
            <?php
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
                    echo ('<a href="reserve.php?isbn=' . htmlentities($row["ISBN"]) . '">Reserve</a> ');
                    echo "</td></tr>\n";
                }
            } else {
                echo "<tr><td colspan='6'>No results found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <br><br><br><br><br><br>
    <div class="pagination">
        <?php
        // Check if pagnum  exists in  $_GET array
        if (isset($_GET['pagnum'])) {
            $pagnum = (int)$_GET['pagnum'];

            // Check in case there are more results 
            if ($result->num_rows > 0) {
                if ($pagnum > 0) {
                    echo "<a href='" . generatePaginationURL($pagnum - 1) . "'>Previous Page</a>";
                }
                echo " | ";
                echo "<a href='" . generatePaginationURL($pagnum + 1) . "'>Next Page</a>";
            }
        }
        ?>
    </div>

    <footer class="footer">
        <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
            All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
    </footer>
</body>

</html>