<!--Coded by Ryan Sands - z1918476-->
<!--login page-->
<?php
    require_once("./util/creds.php");
    require_once("./util/sqlFunc.php");
    require_once("./util/sessionStart.php");


    if (isset($_POST['Login'])) 
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        //query for login details
        $result = fetch($pdo, "SELECT * FROM users WHERE username=? AND pass=?", [$username, $pass]);
        
        //if there is no match
        if($result == false)
        {
            echo("<p>Either account doesn't exist or you entered an incorrect username or password</p>");
        }
        else //otherwise log them in
        {
            //set session variables
            $_SESSION['uid'] = $result['userID'];
            if ($result['isOwner'] == 1) $_SESSION['permLevel'] = 2;
            else if ($result['isEmployee'] == 1) $_SESSION['permLevel'] = 1;
            else $_SESSION['permLevel'] = 0;
            //redirect to productlist
            header("Location: ./productList.php");
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
            $stmt = execute($pdo, "INSERT INTO users (username, pass) VALUES (?,?)", [$username, $pass]);

            //if success
            if($stmt)
            {
                echo("<body style='background-color:#1a1918;'><p style='font-family:Consolas;color:#ffffff;text-align:center;'>Registered successfully! Logging you in automatically in 3 seconds...</p>");
                $result = fetch($pdo, "SELECT * FROM users WHERE username=?", [$username]);

                //get userid session variable
                $_SESSION['uid'] = $result['userID'];

                //redirect to productList
                header("Refresh: 3; ./productList.php");
                exit();
            }
        }
        else 
        {
            echo("<p>Registration failed: Username already exists</p>");
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <link rel='stylesheet' href='./style/login.css'/>
        <title>Web Store - Login</title>
    </head>

    <body>
        <form action="" method="post">
            <h3>Login</h3>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter your username..." required/>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password..." required/>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Register" value="Register"/>
        </form>
    </body>
</html>