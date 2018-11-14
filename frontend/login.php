<?php
require_once('database.php');

$un = $_POST['username']
$pw = $_POST['password']

$q_user = "SELECT * FROM Users WHERE username='$un' AND password='$pw'"
$q_admin = "SELECT * FROM Admins WHERE username='$un' AND password='$pw'"

$userdb = $conn->query($q_user);
if ($userdb == FALSE) {
  $user = $conn->query($q_admin);
  if ($userdb == FALSE) {
    echo "No user found!";
  } else {
    $type = 1
    require_once('../objects/admin.php');
    $user = new Admin();
    echo "Logged in as Admin.";
  }
} else {
  $type = 0
  $user = new User($userdb['username'], $userdb['password'], $userdb['cart']);
  require_once('../objects/user.php');
  echo "Logged in as Customer.";
}



?>
