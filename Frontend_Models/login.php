<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 1); ?>


<!DOCTYPE html>
<html lang='en'>
    <head>
        <link href="css.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <title>Maroon Gaming Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            
        </style>
    </head>
    <body>
	<?php include("frontend/design-top.php");?>
	<?php include("frontend/navigation.php");?>
        <?php
            
            // implement database->getAllUsers($username): returns ['$username', '$type'] 
        
            // implement common->mysql_entities_fix_string($connection, $variable): returns sanitized string (real_escape_string(), passed through htmlentities())

            require_once(dirname(__DIR__)."/Backend_Models/common.php");
            require_once(dirname(__DIR__)."/Database/dbAPI.php");

            $error_string = NULL;
            // Initialize the object for Common.php
            $common = new common;

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
                    $result = $database->getAllAdmins($un_temp);
                    $admin_check = "checked";
                }
                else
                    $result = $database->getAllUsers($un_temp);   
            
                // Validate the password and set session variables
                if ($result)
                {
                    $token = $common->hashPassword()

                    if ($token == $result[0]['password'])
                    {
                        $error_string = NULL;
                        $common->setSession($un_temp, $result[0]['type']);
                        redirectUser();
                    }
                }
                else 
                    $error_string = "Your username/password combination is incorrect. Try Again!";
            }
            else
                $error_string = "Your username/password combination is incorrect. Try Again!";
          
        ?>


                
        <p style="color: red">
        <!--Placeholder for error messages-->
        <span class="error"><?php echo $error_string; ?></span>
            <br><br>
        </p>
        
	<div id="login">
    <h3 class="text-center text-white pt-5">Login form</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" action="login.php" method="post">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="text" name="password" id="password" class="form-control">
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="signup.php" class="text-info">Register here</a>
                        </div>
						    <input type="checkbox" name="admin_check"  <?php echo $admin_check; ?>>
							Are you an Admin?<br>
							<input type="submit" value="Log in">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        
<?php include("frontend/footer.php");?>
    </body>
</html>

<?php
    // redirect user to index.php
    function redirectUser()
    {
        header('Location: index.php');
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
