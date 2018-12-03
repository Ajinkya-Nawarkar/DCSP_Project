<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 1); ?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <title>Maroon Gaming Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
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

            hr {
                border: 1px solid #f1f1f1;
                margin-bottom: 25px;
            }

            /* Set a style for all buttons */
            button {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            button:hover {
                opacity:1;
            }

            /* Extra styles for the cancel button */
            .cancelbtn {
                padding: 14px 20px;
                background-color: #f44336;
            }

            /* Float cancel and signup buttons and add an equal width */
            .cancelbtn, .signupbtn {
              float: left;
              width: 50%;
              padding: 20px;
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

            /* Change styles for cancel button and signup button on extra small screens */
            @media screen and (max-width: 300px) {
                .cancelbtn, .signupbtn {
                   width: 100%;
                }
            }
        </style>
    </head>
    <body>
      <?php
        # STILL NEED TO IMPROVE ENTRY SANITATION

        if (isset($_SESSION['type'])) {
          redirectUser();
        }

        require_once(dirname(__DIR__)."/Backend_Models/Common.php");
        require_once(dirname(__DIR__)."/Backend_Models/user.php");
        require_once(dirname(__DIR__)."/Database/dbAPI.php");
        
        # Initialize the object for database API and Common.php
        $db = new dbAPI;
        $common = new Common;

        # Input variables
        $firstName = "";
        $lastName = "";
        $username = "";
        $password1 = "";
        $password2 = "";

        # Error message variables
        $unErr = "";
        $pw1Err = "";
        $pw2Err = "";
        $errFlg = False;

        # Check if submission has been made
        if (!empty($_POST)) {

          if (!empty($_POST['firstName'])) 
          {
            $firstName = $_POST['firstName'];
          } 

          if (!empty($_POST['lastName'])) 
          {
            $lastName = $_POST['lastName'];
          } 

          if (!empty($_POST['username'])) 
          {
            $username = $_POST['username'];
            $unExists = False;
            if (strlen($username) < 4 or !ctype_alnum($username)) 
            {
              $unErr = "Username must be at least 4 alphanumeric characters.";
              $errFlg = True;
            } 
            else 
            {
              # CHECK IF USERNAME ALREADY EXISTS IN DATABASE
              if ($db->query("SELECT username FROM users WHERE username='$username'")) 
              {
                $unExists = True;
              }
              if ($unExists) 
              {
                $unErr = "Username already exists. Please try another one.";
                $errFlg = True;
              }
            }
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
          # While no error occurs, you still don't want to run the user entry to the database before a submission is made
          $errFlg = True;
        }

        if (!$errFlg) 
        {
          $encryptedPw = $common->hashPassword($password1);
          # ADD USER TO DATABASE HERE
          $user = new User($username, $encryptedPw, $firstName, $lastName);
          $user->addUserToDB();
          $common->setSession($username, "user");
          redirectUser();
        }
      ?>

      <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align">

            <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
            <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>

            <a href='login.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-teal' title='Login'><i class='fa fa-sign-in' aria-hidden='true'></i>  Log in</a>
        </div>
      </div>
    
      <form action="signup.php" method="post" style="border:1px solid #ccc">
        <div align="center" class="container">
          
          <h2 style="margin-top:15px; margin-bottom: 10px" class="text-center text-info"><b>Sign Up</b></h2>
          <p style="margin-top: 10px; margin-bottom:20px" class="text-center text-info"><b>Please fill in this form to create an account.</b></p>

          <label for="firstName"><b>First Name</b></label><br>
          <input type="text" placeholder="Enter your first name" name="firstName" required value="<?php echo $firstName; ?>"><br>

          <label for="lastName"><b>Last Name</b></label><br>
          <input type="text" placeholder="Enter your last name" name="lastName" required value="<?php echo $lastName; ?>"><br>

          <label for="username"><b>Username</b></label><br>
          <input type="text" placeholder="Enter your username" name="username" required value="<?php echo $username; ?>"><br>
          <?php if ($unErr)
                {
                    echo "<p style='color: red'>";
                    echo "<span class='error'>";
                    echo $unErr; 
                    echo "</span><br></p>";
                }?>

          <label for="password1"><b>Password</b></label><br>
          <input type="password" placeholder="Enter Password" name="password1" required><br>
          <?php if ($pw1Err)
                {
                    echo "<p style='color: red'>";
                    echo "<span class='error'>";
                    echo $pw1Err; 
                    echo "</span><br></p>";
                }?>

          <label for="password2"><b>Repeat Password</b></label><br>
          <input type="password" placeholder="Repeat Password" name="password2" required><br>
          <?php if ($pw2Err)
                {
                    echo "<p style='color: red'>";
                    echo "<span class='error'>";
                    echo $pw2Err; 
                    echo "</span><br></p>";
                }?>
          
          <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

          <div class="clearfix">
            <a href="login.php"><button type="button" class="cancelbtn">Cancel</button></a>
            <button type="submit" value="Sign Up" class="signupbtn">Sign Up</button>
          </div>
        </div>
      </form>

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
?>
