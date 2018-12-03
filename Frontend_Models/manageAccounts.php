<?php
    session_start();
?>
<!DOCTYPE html>
<html>
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
  /*if ($_SESSION['type'] != "admin") {
    redirectUser();
  }

  require_once(dirname(__DIR__)."/Backend_Models/common.php");
  require_once(dirname(__DIR__)."/Backend_Models/admin.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");

  $db = new dbAPI;

  $common = new Common;

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
      # CHECK IF USERNAME ALREADY EXISTS IN DATABASE
      if ($db.getOneAdmin($unAdmin)) {
        $check = True;
      }
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
    # ADD ADMIN TO DATABASE HERE
    $admin = new Admin($unAdmin, $encryptedPw, $fnAdmin, $lnAdmin);
    $admin.addAdminToDB();
  }

  # Remove acccount (user/admin)
  if (!empty($_POST['remove_submit'])) {
    if (!empty($_POST['unRemove'])) {
      $unRemove = $_POST['unRemove'];
      if (isset($_POST['adminCheck'])) {
        $adminCheck = "checked";
        $isAdmin = True;
      } else {
        $isAdmin = False
      }
      $check = False;
      # CHECK IF USER/ADMIN USERNAME EXITS IN DATABASE (dependent on $isAdmin)
      if ($isAdmin) {
        if ($db.getOneAdmin($unRemove)) {
          $check = True;
        }
      } else {
        if ($db.getOneUser($unRemove)) {
          $check = True;
        }
      }
      if ($check) {
        $unRemErr = "This username does not exist";
      } else {
        # REMOVE USER/ADMIN ACCOUNT FROM RESPECTIVE DATABASE
        if ($isAdmin) {
          $db.deleteAdmin($unRemove);
        } else {
          $db.deleteUser($unRemove);
        }
      }
    } else {
      $unRemErr = "You must enter an accounts username.";
    }
  }*/
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
