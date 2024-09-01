<?php

session_start();
session_destroy();//log out remove user from session
echo("<link rel='stylesheet' type='css' href='css/style.css'>");//link with css
echo "<h3 class='response'>You have been successfully logged out.</h3>";
header("Location: index.html");

exit;

?>