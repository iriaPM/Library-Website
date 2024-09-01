<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
   
</head>
<body style="background-color: rgba(255,255,255, 2); background-image: url('images/background1.jpg');"  >
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
            </ul>
        </div>
    </header>
    <?php
      
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        require_once "DBconn.php";
                
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if all fields are filled
            if (
                isset($_POST['Username']) && isset($_POST['Password']) &&
                isset($_POST['FirstName']) && isset($_POST['Surname']) &&
                isset($_POST['AddressLine1']) && isset($_POST['AddressLine2']) &&
                isset($_POST['City']) && isset($_POST['Telephone']) && isset($_POST['Mobile'])
            ) 
            {
                // Check if numbers are not empty
                $telephone = $_POST['Telephone'];
                $mobile = $_POST['Mobile'];
        
                if (!empty($telephone) && !empty($mobile)) 
                {
                    // Check if numbers have 8 digits
                    if (strlen($telephone) === 8 && strlen($mobile) === 10) 
                    {
                        $password = $_POST['Password'];
                        $confirmPassword = $_POST['ConfirmPassword'];
                        if(strlen($password)>= 6 && $password == $confirmPassword){

                            $n = $conn->real_escape_string($_POST['Username']);
                            $e = $conn->real_escape_string($_POST['Password']);
                            $p = $conn->real_escape_string($_POST['FirstName']);
                            $d = $conn->real_escape_string($_POST['Surname']);
                            $an = $conn->real_escape_string($_POST['AddressLine1']);
                            $ad = $conn->real_escape_string($_POST['AddressLine2']);
                            $ct = $conn->real_escape_string($_POST['City']);
                            $tl = $conn->real_escape_string($telephone);
                            $mb = $conn->real_escape_string($mobile);
            
                            $sql = "INSERT INTO users (Username, Password, FirstName, Surname,AddressLine1,AddressLine2,City,Telephone,Mobile) 
                                VALUES ('$n', '$e', '$p','$d','$an','$ad','$ct','$tl','$mb')";
                            if ($conn->query($sql) === TRUE) 
                            {
                                echo "<h3 class='response'>You have been registered successfully</h3>";
                            } 
                          
                        }else {
                            echo "<h3 class='response'>Error:  must match and should be at least 6 characters ";
                        }    
                    }  } else 
                    {
                        echo "<h3 class='response'>Error: Telephone and Mobile numbers must have 8 digits.</h3>";
                    }
                } 
                else 
                {
                    echo "<h3 class='response'>Error: All fields are required.</h3>";
                }
        }
    ?>
    
    <section>
    <form class="forms" action="register.php" method="post">
        <div class="formone" >
            <p>Username:</p>
            <input type="text" name="Username" required>
            <p>Password:</p>
            <input type="password" name="Password" required>
            <p>FirstName:</p>
            <input type="text" name="FirstName" required>
            <p>Surname:</p>
            <input type="text" name="Surname" required>
            <p><input type="submit" value="Register"/></p>
        </div>
        <div class="formone" >
            <p>Address Line 1:</p>
            <input type="text" name="AddressLine1" required>
            <p>Address Line 2:</p>
            <input type="text" name="AddressLine2" required>
            <p>City:</p>
            <input type="text" name="City">
            <p>Telephone:</p>
            <input type="number" name="Telephone" required>
            <p>Mobile:</p>
            <input type="number" name="Mobile" required>
        </div>
       
    </form>
    </section>
    <footer class="footer">
    <p class="footerlinks">Developed by: Iria Parada C22305863 TU 856 2nd year Web Development 2023 
         All images/videos are from <a href="https://images.google.com/">Google Images</a></p>
        
    </footer>
</body>
</html>