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
            #editAccount{
                margin-top: 80px;
                margin-left: 30px;
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
                margin-top: 200px;
                padding-bottom: 200px;
            }
            
            body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}
             /* Full-width input fields */
            input[type=text], input[type=password] {
                width: 25%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }
             input[type=text]:focus, input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }
            /* Add padding to container elements */
            .container {
                padding: 16px;
            }
             /* Clear floats */
            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }
            b.skuOutput {
                margin-left: 15px;
                width: 7%;
                display: inline-block;
                padding: 7px;
                border: none;
                background: #f1f1f1;
            }
             }
        </style>
    </head>
    <body>
        <?php
             // Send the #SKU using this format -> href='Frontend_Models/editItem.php?varSku=$sku'

            require_once(dirname(__DIR__)."/Backend_Models/Common.php");
            require_once(dirname(__DIR__)."/Database/dbAPI.php");
            
            // Initialize the objects
            $db = new dbAPI;
            $common = new Common;
            
            // Extract the username
            $username = $_SESSION['username'];

            // Initialize the variables 
            $result = $db->getUserDetails($username);
            
            $firstname = $result['firstname'];
            $lastname = $result['lastname'];
            $password1 = "";
            $password2 = "";
            $encryptedPw = "";
            
            # Error message variables
            $pw1Err = "";
            $pw2Err = "";
            $errFlg = False;
            
            # Check if submission has been made
            if (!empty($_POST)) 
            {
              if (isset($_POST['firstname'])) 
              {
                $firstname = $_POST['firstname'];
              }
               if (isset($_POST['lastname'])) 
              {
                $lastname = $_POST['lastname'];
              } 
              if (!empty($_POST['password1'])) 
              {
                $password1 = $_POST['password1'];
                if (!preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{8,}$/', $password1)) 
                {
                  $pw1Err = "Not a valid password: must be at least 8 characters {a-z, A-Z, 0-9}.";
                  $errFlg = True;
                }
                if (!empty($_POST['password2'])) 
                {
                  $password2 = $_POST['password2'];
                  if ($password1 != $password2) 
                  {
                    $pw2Err = "Your password entries do not match.";
                    $errFlg = True;
                  }
                } 
              } 
            }
            else {
              # While no error occurs, you still don't want to run the item entry to the database before a submission is made and redirect to index.php
              $errFlg = True;
            }    
             if (!$errFlg) 
            {
                if ($password1 != ""){
                  $encryptedPw = $common->hashPassword($password1);
                }
                # ADD ITEM TO DATABASE HERE
                $db->editAccount($username, $encryptedPw, $firstname, $lastname);
                redirectUser();
            }       
        ?>

     <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align">
             <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
            
            <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>

             <a href='Frontend_Models/viewCart.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Cart</a>
             
             <a href='logout.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-teal' title='Logout'><i class='fa fa-sign-in' aria-hidden='true'></i> Logout</a>
        </div>
    </div>
        
    <div align="left" id="editAccount">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" action="editAccount.php" method="post">
                        <h2 class="text-center text-info"><b>Edit Account</b></h2>
                        <p class="text-center text-info" style="margin-top: 5px"><b>Please edit your account details</b> <b class="unOutput">#Username: <?php echo $username; ?></b></p>
                        
                        <input type="hidden" name="sku" id="sku" value="<?php echo $sku; ?>"><br>
 
                        <label for="firstname" class="text-info"><b>First Name:</b></label><br>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="firstname" style="width: 235px;" required value="<?php echo $firstname; ?>"><br>
                         
                        <label for="lastname"><b>Last Name: </b></label><br>
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?php echo $lastname; ?>" style="width: 235px;" required value="<?php echo $lastname; ?>"><br>
                        
                        <label for="password1"><b>Password</b></label><br>
                        <input type="password" placeholder="Enter Password (optional)" name="password1" value="<?php echo $password1; ?>"><br>
                        <?php if ($pw1Err)
                              {
                                  echo "<p style='color: red'>";
                                  echo "<span class='error'>";
                                  echo $pw1Err; 
                                  echo "</span><br></p>";
                              }?>

                        <label for="password2"><b>Repeat Password</b></label><br>
                        <input type="password" placeholder="Repeat Password (optional)" name="password2" value="<?php echo $password2; ?>"><br>
                        <?php if ($pw2Err)
                              {
                                  echo "<p style='color: red'>";
                                  echo "<span class='error'>";
                                  echo $pw2Err; 
                                  echo "</span><br></p>";
                              }?>
                        
                        <div class="form-group-submit">
                            <input style="background-color: #4CAF50; color: white" type="submit" value="Edit Account">
                        </div>
                    </form>
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