<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 0); ?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <link href="css.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <title>Maroon Gaming Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            #login{
                margin-top: 80px;
            }
            .text-center{
            margin-top: -10px;
            }
            .form-group{
                margin-top: 5px;
                padding-bottom: 3px;
            }
            .form-group-submit{
                margin-top: 14px;
                padding-bottom: 2px;
            }
            footer{
                margin-top: 160px;
                padding-bottom: 200px;
            }
            body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}

            input[type=text], input[type=password] {
                width: 25%;
                padding: 15px;
                margin: 5px 0 5px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus, input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }
        </style>
    </head>
    <body>
        <?php

            require_once(dirname(__DIR__)."/Backend_Models/Common.php");
            require_once(dirname(__DIR__)."/Database/dbAPI.php");

            // Initialize the variables and object for Common.php
            $error_string = NULL;
            $admin_check = "";
            $type = "";
            $common = new Common;

            if (isset($_SESSION['type']))
                redirectUser();
            
            // Preserve the username to show if only password is incorrect
            $username = isset($_POST['username']);
            
            if (isset($_POST['username']) && isset($_POST['password'])) 
            {
                // Initialize the object for Database.php
                $database = new dbAPI;

                $un_temp = mysql_entities_fix_string($database->connection, $_POST['username']);
                $pw_temp = mysql_entities_fix_string($database->connection, $_POST['password']);

                // admin_check validation
                if(isset($_POST['admin_check']))
                {
                    $result = $database->getOneAdmin($un_temp);
                    $admin_check = "checked";
                    $type = "admin";
                }
                else{
                    $result = $database->getOneUser($un_temp);   
                    $type = "user";
                }
            
                // Validate the password and set session variables
                if ($result)
                {
                    $token = $common->hashPassword($pw_temp);

                    if ($token == $result[1])
                    {
                        $error_string = NULL;
                        $common->setSession($un_temp, $type);
                        redirectUser();
                    }
                    else
                        $error_string = "Your username/password combination is incorrect. Try Again!";
                }
                else 
                    $error_string = "Your username/password combination is incorrect. Try Again!";
            }
                     
        ?>

    <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align">

            <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
            <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>

            <a href='signup.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-teal' title='Signup'><i class='fa fa-sign-in' aria-hidden='true'></i>  Signup</a>
        </div>
    </div>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        <span class="error"><?php echo $error_string; ?></span>
            <br><br>
        </p>
        
	<div align="center" id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" action="login.php" method="post">
                        <h2 class="text-center text-info"><b>Sign In</b></h2>
                        <p class="text-center text-info" style="margin-top: 5px"><b>Please sign in with your username and password below.</b></p>
                        
                        <div class="form-group" style="margin-top: 30px">
                            <label for="username" class="text-info" style="margin-right: 10px;"><b>Username:</b></label>
                            <input type="text" name="username" id="username" placeholder="&nbsp;&emsp;Email Address / Username" class="form-control" style="width: 235px;" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="text-info" style="margin-right: 13px"><b>Password:</b></label>
                            <input type="password" name="password" id="password" placeholder="&emsp;&nbsp;Password" class="form-control" style="width: 235px;" required>
                        </div>
						    
                        <div class="form-group" style="margin-top: 10px">
                            <input type="checkbox" name="admin_check"  <?php echo $admin_check; ?>>
						      Are you an Admin?<br>
                        </div>
						
                        <?php
                            if ($error_string)
                            {
                                echo "<p style='color: red'>";
                                echo "<span class='error'>";
                                echo $error_string; 
                                echo "</span><br></p>";
                            }
                        ?>
                        
                        <div class="form-group-submit">
                            <input style="background-color: #4CAF50; color: white" type="submit" value="Log in">
                        </div>
                    </form>
                </div>
                <br>
                <div id="register-link" class="text-right">
                    <p style="font-style:italic">I am new here.<a style="margin-left:100px" href="signup.php" class="w3-bar-item w3-button w3-teal">Sign Up here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
        
<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
    <h4>Maroon Gaming Co. @ 2018</h4>
</footer>

    </body>
</html>

<?php
    // redirect user to index.php
    function redirectUser()
    {
        header('Location: ../index.php');
        exit();
    }

    //helper functions to sanitize user entries
    function mysql_entities_fix_string($connection, $string)
    {
      return htmlentities(mysql_fix_string($connection, $string));
    }
    
    function mysql_fix_string($connection, $string)
    {
      if (get_magic_quotes_gpc()) $string = stripslashes($string);
      return $connection->real_escape_string($string);
    }

?>
