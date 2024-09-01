<?php
session_start();
require_once "DBconn.php";
echo("<link rel='stylesheet' type='css' href='css/style.css'>");//link with css


// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    // Redirect to login page 
    header("Location: login.php");
    exit();
}


if (isset($_POST['ISBN'])) {
    $isbn = $conn->real_escape_string($_POST['ISBN']);

    // Update books table to set IsReserved to 'N'
    $updateQuery = $conn->query("UPDATE books SET IsReserved = 'N' WHERE ISBN = '$isbn'");

    // Delete the reservation entry
    $deleteQuery = $conn->query("DELETE FROM reservations WHERE ISBN = '$isbn'");

    if ($updateQuery && $deleteQuery) {
        
        echo "<div class='response'><h2>Book has been unreserved</h2></div>";
        
        
    } else {
        
        echo "<div class='response'><h2>Error unreserving the book</h2></div>";
        
    }
} else {
   
    echo "<div class='response'><h2>ISBN not provided</h2></div>";
    
}
?>
