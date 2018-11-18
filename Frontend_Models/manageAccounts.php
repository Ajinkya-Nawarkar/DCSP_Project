<?php
    include("login_credentials.php");
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <?php
  if ($_SESSION['type'] != "admin") {
    redirectUser();
  }

  require_once(dirname(__DIR__)."/Backend_Models/common.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");

  $connection = new mysqli($hn, $un, $pw, $db);
  if ($connection->connect_error)
    die($connection->connect_error);

  # Initialize the object for Common.php
  $common = new common;

  # Input variables
  $fnAdmin = "";
  $lnAdmin = "";
  $unAdmin = "";
  $pw1Admin = "";
  $pw2Admin = "";
  $unRemove = "";
  $adminCheck = "";

  # Error message variables
  $fnAdErr = "";
  $lnAdErr = "";
  $unAdErr = "";
  $pw1AdErr = "";
  $pw2AdErr = "";
  $unRemErr = "";
  $adErrFlg = False;

  # Add new Admin
  if (!empty($_POST['admin_submit'])) {
    if (!empty($_POST['firstName'])) {
      $fnAdmin = $_POST['firstName'];
    } else {
      $fnAddErr = "You must enter your first name.";
      $adErrFlg = True;
    }
    if (!empty($_POST['lastName'])) {
      $lnAdmin = $_POST['lastName'];
    } else {
      $lnAdErr = "You must enter your last name.";
      $adErrFlg = True;
    }
    if (!empty($_POST['unAdmin'])) {
      $unAdmin = $_POST['unAdmin'];
      $check = False;
      #########################
      # CHECK IF USERNAME ALREADY EXISTS IN DATABASE
      ########################
      if ($check) {
        $unAdErr = "Username already exists. Please try another one.";
        $adErrFlg = True;
      }
    } else {
      $unAdErr = "You must enter a username.";
      $adErrFlg = True;
    }
    if (!empty($_POST['password1'])) {
      $pw1Admin = $_POST['password1'];
      if (!preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{8,}$/', $pw1Admin)) {
        $pw1AdErr = "Not a valid password: must be 8 characters {a-z, A-Z, 0-9}.";
        $adErrFlg = True;
      }
      if (!empty($_POST['password2'])) {
        $pw2Admin = $_POST['password2'];
        if ($pw1Admin != $pw2Admin) {
          $pw2AdErr = "Your password entries do not match.";
          $adErrFlg = True;
        }
      } else {
        $pw2AdErr = "You must confirm your password";
        $adErrFlg = True;
      }
    } else {
      $pw1AdErr = "You must enter a password.";
      $adErrFlg = True;
    }
  }

  if (!$adErrFlg) {
    $encryptedPw = $common->hashPassword($pw1Admin);
    #######################################
    # ADD ADMIN TO DATABASE HERE
    #######################################
  }

  # Remove acccount (user/admin)
  if (!empty($_POST['remove_submit'])) {
    if (!empty($_POST['unRemove'])) {
      $unRemErr = "You must enter an accounts username.";
    } else {
      $unRemove = $_POST['unRemove'];
      if (isset($_POST['adminCheck'])) {
        $adminCheck = "checked";
        $admin = True;
      } else {
        $admin = False
      }
      $check = False;
      #####################
      # CHECK IF USER/ADMIN USERNAME EXITS IN DATABASE (dependent on $admin)
      #####################
      if ($check) {
        $unRemErr = "This username does not exist";
      } else {
        #####################
        # REMOVE USER/ADMIN ACCOUNT FROM RESPECTIVE DATABASE (dependent on $admin)
        #####################
      }
    }
  }
  ?>
  <h4>Add New Admin</h4>
  <form method="post" action="manageAccounts.php">
       <label>First Name: </label>
       <input type="text" name="firstName" value="<?php echo $fnAdmin; ?>">
       <span class="error"><?php echo $fnAdErr; ?></span><br>

       <label>Last Name: </label>
       <input type="text" name="lastName" value="<?php echo $lnAdmin; ?>">
       <span class="error"><?php echo $lnAdErr; ?></span><br>

       <label>Username: </label>
       <input type="text" name="unAdmin" value="<?php echo $unAdmin; ?>">
       <span class="error"><?php echo $unAdErr; ?></span><br>

       <label>Password: </label>
       <input type="text" name="password1" value="<?php echo $pw1Admin; ?>">
       <span class="error"><?php echo $pw1AdErr; ?></span><br>

       <label>Confirm Password: </label>
       <input type="text" name="password2" value="<?php echo $pw2Admin; ?>">
       <span class="error"><?php echo $pw2AdErr; ?></span><br>

       <input type="submit" name="admin_submit" value="Add Admin">
     </form><br><br>

     <h4>Remove Account</h4>
     <form method="post" action="manageAccounts.php">
       <label>Username: </label>
       <input type="text" name="unRemove" vale="<?php echo $unRemove; ?>">
       <span class="error"><?php echo $unRemErr; ?></span><br>

       <input type="checkbox" name="adminCheck" value="<?php echo $adminCheck; ?>">
       Admin Account<br>

       <input type="submit" name="remove_submit" value="Remove Account">
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
