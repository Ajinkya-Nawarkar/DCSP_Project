<?php include("login.php");?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <title>Log in to Website</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {
              color: #FF0000;
            }
        </style>
    </head>
    <body>
        <?php

            // start the session
            session_start();

            if (isset($_SESSION['currentUser']))
            {
              $session_type = $_SESSION['currentUser'];

              if ($session_type == 'user'){
                header('Location: user_page.php');
                exit();
              }
              else if ($session_type == 'admin'){
                header('Location: admin_page.php');
                exit();
              }
            }

            $username = "";
            $password = "";
            $loginErr = "";
          
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                //name validation
                if((!empty($_POST['username'])) && (!empty($_POST['password'])))
                {
                    $loginErr = "";
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // connect to the database
                    $mysqli = new mysqli($hn, $un, $pw, $db);
                    if ($mysqli->connect_error)
                      die ($mysqli->connect_error);

                    // create token (hashed password)
                    $salt1    = "qm&h*";
                    $salt2    = "pg!@";
                    $passwordHash = hash('ripemd128', "$salt1$password$salt2");

                    // 
                    $query = "SELECT * FROM lab5_users WHERE username='$username' AND password='$passwordHash'";
                    $result = $mysqli->query($query);    
                    $row = $result->fetch_array();           
                    
                    // check if username / password were valid
                    if (!$row){
                        $loginErr = "Your username / password combination is incorrect";
                    }
                    // redirect the user
                    else
                    {
                      $type = $row['type'];
                      $_SESSION['currentUser'] = $type;  

                      if ($type == 'user'){
                        header('Location: user_page.php');
                        exit();
                      }
                      else if ($type == 'admin'){
                        header('Location: admin_page.php');
                        exit();
                      }

                    }

                }
                else 
                    $loginErr = "You need to enter both username and password";
            }
          
        ?>
        <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: maroon">
                Great Web Application</span>!</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        <span class="error"><?php echo $loginErr; ?></span>
            <br><br>
        </p>
        
        <form method="post" action="login_page.php">
            <label>Username: </label>
            <input type="text" name="username" value="<?php echo $username;?>"> <br>
            <label>Password: </label>
            <input type="password" name="password" value="<?php echo $password;?>"> <br>
            <input type="submit" value="Log in">
        </form>
        
        <p style="font-style:italic">
            Placeholder for "forgot password" link<br><br>
            Placeholder for "create account" link
        </p>
</html>
