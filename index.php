<!--login page-->
<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - Login</title>
    </head>

    <body>
        <h1>Login<h1>
        Either login or register to continue!<br>
        <form action="" method="post">
            Username:
            <input type="text" name="username"/><br>
            Password:
            <input type="text" name="password"/><br>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Register" value="Register"/>
        </form>
    </body>

</html>

<?php
    include("./creds.php");
    require_once("./sessionStart.php");

    //login code
    if(isset($_POST['Login'])) 
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
            //query for login details
            $sql = $pdo->prepare("SELECT * FROM users WHERE username=? AND pass=?");
            $sql->execute([$username, $pass]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            
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
                header("Location: ./productList.php");
                exit();
            }
        }
        catch(PDOexception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    //registration code
    if(isset($_POST['Register']))
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
            //check that the username is not already in use
            $sql = $pdo->prepare("SELECT * FROM users WHERE username=?");
            $sql->execute([$username]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            
            //if nothing comes back, we're good to try and create an account for them
            if($result == false)
            {
                //insert statment
                $sql = "INSERT INTO users (username, pass)
                VALUES (?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $pass]);

                //if success
                if($stmt)
                {
                    echo("Registered successfully!");
                    $sql = $pdo->prepare("SELECT * FROM users WHERE username=?");
                    $sql->execute([$username]);
                    $result = $sql->fetch(PDO::FETCH_ASSOC);

                    //get userid session variable
                    $_SESSION['uid'] = $result[userID];

                    //redirect to productlist
                    header("Location: ./productList.php");
                }
            }
            else 
            {
                echo("Registration failed: Username already exists");
                return;
            }
        }
        catch(PDOexception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>