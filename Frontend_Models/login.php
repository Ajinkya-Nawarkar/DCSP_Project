<?php 
    // include the database credentials
    include("login.php");
    // start the session
    session_start();
?>


<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <title>Maroon Gaming Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            
        </style>
    </head>
    <body>
        <?php
            
            // implement database->getUsers($username): returns ['$username', '$type'] 
        
            // implement common->mysql_entities_fix_string($connection, $variable): returns sanitized string (real_escape_string(), passed through htmlentities())

            require_once(dirname(__DIR__)."/Backend_Models/common.php");
            require_once(dirname(__DIR__)."/Database/dbAPI.php");

            $error_string = NULL;
            // Initialize the object for Common.php
            $common = new common;

            // Initialize database
            $connection = new mysqli($hn, $un, $pw, $db);
            if($connection->connect_error) die($connection->connect_error);

            if (isset($_SESSION['type']))
                redirectUser();
            
            // Preserve the username to show if only password is incorrect
            $username = isset($_POST['username']);
            
            if (isset($_POST['username']) && isset($_POST['password'])) 
            {
                $un_temp = common->mysql_entities_fix_string($connection, $_POST['username']);
                $pw_temp = common->mysql_entities_fix_string($connection, $_POST['password']);

                // Initialize the object for Database.php
                $database = new dbAPI;
                $result = $database->getUsers($un_temp);   
            
                if ($result)
                {
                    $token = common->hashPassword()

                    if ($token == $result[0]['password'])
                    {
                        $error_string = NULL;
                        common->setSession($un_temp, $result[0]['type']);
                        redirectUser();
                    }
                }
                else 
                    $error_string = "Your username/password combination is incorrect. Try Again!";
            }
            else
                $error_string = "Your username/password combination is incorrect. Try Again!";
          
        ?>


        <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: maroon">
                Great Web Application</span>!</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        <span class="error"><?php echo $error_string; ?></span>
            <br><br>
        </p>
        
        <form method="post" action="login.php">
            <label>Username: </label>
            <input type="text" name="username" value="<?php echo $username;?>"> <br>
            <label>Password: </label>
            <input type="password" name="password" value="<?php echo $password;?>"> <br>
            <input type="submit" value="Log in">
        </form>
        
        <p style="font-style:italic">
            // Placeholder for "forgot password" link<br><br>
            I am new here! <a href="#create">Create A New Account</a>
        </p>

    </body>
</html>

<?php
    // redirect user to index.php
    function redirectUser()
    {
        header('Location: index.php');
        exit();
    }
?>
