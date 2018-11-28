<?php
    include("login.php");
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
      # Will include navigation.php once it is functional
      //include("navigation.php");

      # STILL NEED TO IMPROVE ENTRY SANITATION

      if (isset($_SESSION['type'])) {
        redirectUser();
      }

      require_once(dirname(__DIR__)."/Backend_Models/common.php");
      require_once(dirname(__DIR__)."/Backend_Models/user.php");
      require_once(dirname(__DIR__)."/Database/dbAPI.php");

      # Initialize database
      $db = new dbAPI;

      # Initialize the object for Common.php
      $common = new common;

      # Input variables
      $firstName = "";
      $lastName = "";
      $username = "";
      $password1 = "";
      $password2 = "";

      # Error message variables
      $fnErr = "";
      $lnErr = "";
      $unErr = "";
      $pw1Err = "";
      $pw2Err = "";
      $errFlg = False;

      # Check if submission has been made
      if (!empty($_POST)) {
        if (!empty($_POST['firstName'])) {
          $firstName = $_POST['firstName'];
        } else {
          $fnErr = "You must enter your first name.";
          $errFlg = True;
        }
        if (!empty($_POST['lastName'])) {
          $lastName = $_POST['lastName'];
        } else {
          $lnErr = "You must enter your last name.";
          $errFlg = True;
        }
        if (!empty($_POST['userame'])) {
          $username = $_POST['username'];
          $check = False;
          if (strlen($username) < 4 or !ctype_alnum($username)) {
            $unErr = "Username must be at least 4 alphanumeric characters.";
            $errFlg = True;
          } else {
            # CHECK IF USERNAME ALREADY EXISTS IN DATABASE
            if ($db.query("SELECT username FROM users WHERE username='$username'")) {
              $check = True;
            }
            if ($check) {
              $unErr = "Username already exists. Please try another one.";
              $errFlg = True;
            }
          }
        } else {
          $unErr = "You must enter a username.";
          $errFlg = True;
        }
        if (!empty($_POST['password1'])) {
          $password1 = $_POST['password1'];
          if (!preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{8,}$/', $password1)) {
            $pw1Err = "Not a valid password: must be at least 8 characters {a-z, A-Z, 0-9}.";
            $errFlg = True;
          }
          if (!empty($_POST['password2'])) {
            $password2 = $_POST['password2'];
            if ($password1 != $password2) {
              $pw2Err = "Your password entries do not match.";
              $errFlg = True;
            }
          } else {
            $pw2Err = "You must confirm your password";
            $errFlg = True;
          }
        } else {
          $pw1Err = "You must enter a password.";
          $errFlg = True;
        }
      }
      else {
        # While no error occurs, you still don't want to run the user entry
        # to the database before a submission is made
        $errFlg = True;
      }

      if (!$errFlg) {
        $encryptedPw = $common->hashPassword($password1);
        # ADD USER TO DATABASE HERE
        $user = new User($username, $encryptedPw, $firstName, $lastName, NULL);
        $user->addUserToDB();
        $common->setSession($username, "user");
        redirectUser();
      }
      # Below is very basic html to make the page functional.
      ?>
      <form method="post" action="signup.php">
        <label>First Name: </label>
        <input type="text" name="firstName" value="<?php echo $firstName; ?>">
        <span class="error"><?php echo $fnErr; ?></span><br>

        <label>Last Name: </label>
        <input type="text" name="lastName" value="<?php echo $lastName; ?>">
        <span class="error"><?php echo $lnErr; ?></span><br>

        <label>Username: </label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span class="error"><?php echo $unErr; ?></span><br>

        <label>Password: </label>
        <input type="text" name="password1" value="<?php echo $password1; ?>">
        <span class="error"><?php echo $pw1Err; ?></span><br>

        <label>Confirm Password: </label>
        <input type="text" name="password2" value="<?php echo $password2; ?>">
        <span class="error"><?php echo $pw2Err; ?></span><br>

        <input type="submit" value="Sign Up">
      </form>
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
