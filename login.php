<!--login page-->
<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="./util/style.php">
        <title>Web Store - Login</title>
    </head>

    <body>
        <h1>Login<h1>
        Either login or register to continue!<br>
        <form action="" method="post">
            Username:
            <input type="text" name="username" required/><br>
            Password:
            <input type="password" name="password" required/><br>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Register" value="Register"/>
        </form>
    </body>

</html>

<?php
    require("creds.php");
    require("sqlFunc.php");
    require_once("sessionStart.php");

    //login code
    if (isset($_POST['Login'])) 
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        //query for login details
        $result = fetch($pdo, "SELECT * FROM users WHERE username=? AND pass=?", [$username, $pass]);
        
        //if there is no match
        if($result == false)
        {
            echo("Incorrect username or password");
            return;
        }
        else //otherwise log them in
        {
            echo("Login successful");
            //set userid session variable
            $_SESSION['uid'] = $result[userID];
            //redirect to productlist
            header("Location: ./index.php");
            exit();
        }

    }

    //registration code
    if (isset($_POST['Register']))
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        //check that the username is not already in use
        $result = fetch($pdo, "SELECT * FROM users WHERE username=?", [$username]);
        
        //if nothing comes back, we're good to try and create an account for them
        if($result == false)
        {
            //try to insert
            $stmt = insert($pdo, "INSERT INTO users (username, pass) VALUES (?,?)", [$username, $pass]);

            //if success
            if($stmt)
            {
                echo("Registered successfully!");
                $result = fetch($pdo, "SELECT * FROM users WHERE username=?", [$username]);
                

                //get userid session variable
                $_SESSION['uid'] = $result[userID];

                //redirect to productList
                header("Location: ./index.php");
            }
        }
        else 
        {
            echo("Registration failed: Username already exists");
            return;
        }
    }
?>