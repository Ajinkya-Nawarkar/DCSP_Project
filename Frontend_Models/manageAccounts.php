<?php
    session_start(); error_reporting(E_ALL); ini_set('display_errors', 0);
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
        #ma {
          margin-top:80px;
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

        #ma .container #ma-row #ma-column .ma-box #ma-form {
          padding: 20px;
        }
        #ma .container #ma-row #ma-column .ma-box #ma-form #register-link {
          margin-top: -85px;
        }* {box-sizing: border-box}

        .success {
          color:green;
        }
    </style>
</head>
<body>
  <?php
  if ($_SESSION['type'] != "admin") {
    redirectUser();
  }

  require_once(dirname(__DIR__)."/Backend_Models/Common.php");
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

  $addAdminSucc = "";
  $remAccSucc= "";

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
      if ($db->query("SELECT username FROM admins WHERE username='$unAdmin'")) {
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
        } else {
          $addAdminSucc = "Admin added successfully";
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
    $admin->addAdminToDB();

  }

  # Remove acccount (user/admin)
  if (!empty($_POST['remove_submit'])) {
    if (!empty($_POST['unRemove'])) {
      $unRemove = $_POST['unRemove'];
      if (isset($_POST['adminCheck'])) {
        $adminCheck = "checked";
        $isAdmin = True;
      } else {
        $isAdmin = False;
      }
      $check = True;
      # CHECK IF USER/ADMIN USERNAME EXITS IN DATABASE (dependent on $isAdmin)
      if ($isAdmin) {
        if ($db->query("SELECT username FROM admins WHERE username='$unRemove'")) {
          $check = False;
        }
      } else {
        if ($db->query("SELECT username FROM users WHERE username='$unRemove'")) {
          $check = False;
        }
      }
      if ($check) {
        $unRemErr = "This username does not exist";
      } else {
        # REMOVE USER/ADMIN ACCOUNT FROM RESPECTIVE DATABASE
        if ($isAdmin) {
          $db->deleteAdmin($unRemove);
        } else {
          $db->deleteUser($unRemove);
        }
        $remAccSucc = "Account removed successfully";
      }
    } else {
      $unRemErr = "You must enter an accounts username.";
    }
  }
  ?>
  <div class="w3-top">
      <div class="w3-bar w3-theme-d2 w3-left-align">

          <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gaming - Administrator</a>
          <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
          <a href='Frontend_Models/manageAccounts.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Manage Accounts</a>
          <a href='Frontend_Models/createItem.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Add Item</a>
          <a href='Frontend_Models/logout.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-hover-teal' title='Logout'><i class='fa fa-sign-in' aria-hidden='true'></i> Logout</a>

      </div>
  </div>

  <div align="center" id="ma">
    <div class="container">
        <div id="ma-row" class="row justify-content-center align-items-center">
            <div id="ma-column" class="col-md-6">
                <div class="ma-box col-md-12">
                  <form id="ma-form" class="form" method="post" action="manageAccounts.php">
                    <h2 class="text-center text-info"><b>Add New Admin</b></h2><br>
                      <span class="success"><?php echo $addAdminSucc; ?></span><br>

                       <label for="firstName" class="text-info"><b>First Name: </b></label><br>
                       <input type="text" name="firstName" placeholder="Enter First Name" required value="<?php echo $fnAdmin; ?>"><br>
                       <span class="error"><?php echo $fnAdErr; ?></span><br>

                       <label for="lastName" class="text-info"><b>Last Name: </b></label><br>
                       <input type="text" name="lastName" placeholder="Enter Last Name" required value="<?php echo $lnAdmin; ?>"><br>
                       <span class="error"><?php echo $lnAdErr; ?></span><br>

                       <label for="unAdmin" class="text-info"><b>Username: </b></label><br>
                       <input type="text" name="unAdmin" placeholder="Enter Username" required value="<?php echo $unAdmin; ?>"><br>
                       <span class="error"><?php echo $unAdErr; ?></span><br>

                       <label for="password1" class="text-info"><b>Password: </b></label><br>
                       <input type="password" name="password1" placeholder="Enter Password" required value="<?php echo $pw1Admin; ?>"><br>
                       <span class="error"><?php echo $pw1AdErr; ?></span><br>

                       <label for="password2" class="text-info"><b>Confirm Password: </b></label><br>
                       <input type="password" name="password2" placeholder="Repeat Password" required value="<?php echo $pw2Admin; ?>"><br>
                       <span class="error"><?php echo $pw2AdErr; ?></span><br>

                       <input style="background-color: #4CAF50; color: white" type="submit" name="admin_submit" value="Add Admin">
                     </form><br><br><hr width="60%"><br><br>

                     <h2 class="text-center text-info"><b>Remove Account</b></h2><br>
                     <span class="success"><?php echo $remAccSucc; ?></span><br>
                     <form id="ma-form" class="form" method="post" action="manageAccounts.php">
                       <label for="unRemove" class="text-info"><b>Username: </b></label><br>
                       <input type="text" name="unRemove" placeholder="Enter Username" required value="<?php echo $unRemove; ?>"><br>
                       <span class="error"><?php echo $unRemErr; ?></span><br>

                       <input type="checkbox" name="adminCheck" value="<?php echo $adminCheck; ?>">
                       Admin Account<br><br><br>

                       <input style="background-color: #4CAF50; color: white" type="submit" name="remove_submit" value="Remove Account">
                     </form>
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
?>
