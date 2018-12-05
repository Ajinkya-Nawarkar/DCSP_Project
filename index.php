
<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 0); ?>

<!DOCTYPE html>
<html>
<title>Maroon Gaming</title>
<style>
* {
    box-sizing: border-box;
}
form.example input[type=text] {
    padding: 10px;
    font-size: 17px;
    border: 1px solid grey;
    float: left;
    width: 80%;
    background: #f1f1f1;
}
.add{
  color: white
}
.add:hover{
  color: white;
}
.submitbtn {
    float: left;
    width: 20%;
    padding: 10px;
    background: #800000;
    color: white;
    font-size: 17px;
    border: 1px solid grey;
    border-left: none;
    cursor: pointer;
}
form.example button:hover {
    background: #D3D3D3;
}
form.example::after {
    content: "";
    clear: both;
    display: table;
}
#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}
.btn {
    border: none;
    background-color: #4CAF50;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;

}
.redbtn{
  border: none;
  background-color: #800000;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  width:200px;
  height: 60px;
}
.bluebtn{
  border: none;
  background-color: teal;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  width:100px;
  height: 60px;
}
.btncont{
  text-align: center;

}
.redbtn{
  border: none;
  background-color: #800000;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  width:200px;
  height: 60px;
}
.bluebtn{
  border: none;
  background-color: teal;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  width:100px;
  height: 60px;
}
.btncont{
  text-align: center;

}
/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}
.active {
  background-color: #717171;
}

.item{
  background-color: white;
  width: 350px;
  height: 250px;
  border: 3px solid #800000;
  position: relative;
  margin-top: 20px;
  margin-bottom: 20px;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}
@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}
@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}
/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body id="myPage">


<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>
  <?php
      //display different banner identification based on session type
        if(isset($_SESSION['type'])){
        switch ($_SESSION['type']) {
          case 'user':
            echo "Maroon Gaming - Basic User";
            break;
          case 'admin':
            echo "Maroon Gaming - Administrator";
            break;
        }
      }
      else{
        echo "";
      }
      ?></a>

  <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>

  <?php
  	if(isset($_SESSION['type'])){
      switch ($_SESSION['type']) {
        case 'user':
          echo "<a href='Frontend_Models/editAccount.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Account</a>";
          echo "<a href='Frontend_Models/viewCart.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Cart</a>";
          break;
        case 'admin':
          echo "<a href='Frontend_Models/manageAccounts.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Manage Accounts</a>";
          echo "<a href='Frontend_Models/createItem.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Add Item</a>";
          break;
      }
    }
    else{
      echo "<a href='Frontend_Models/login.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'><i class='fa fa-sign-in' aria-hidden='true'></i> Login / Signup</a>";
    }
    ?>

    <?php
  		if(isset($_SESSION['type'])){
	  		echo "<a href='Frontend_Models/logout.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-hover-teal' title='Logout'><i class='fa fa-sign-in' aria-hidden='true'></i> Logout</a>";
	  	}
	  	else{
	  		echo "";
	  	}
  	?>

 </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium">
    <a href="#team" class="w3-bar-item w3-button">Team</a>
    <a href="#work" class="w3-bar-item w3-button">Work</a>
    <a href="#pricing" class="w3-bar-item w3-button">Price</a>
    <a href="#contact" class="w3-bar-item w3-button">Contact</a>
    <a href="#" class="w3-bar-item w3-button">Search</a>
  </div>
</div>

<!-- Image Header -->


<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="Assets/banner.png" style="width:100%;min-height:300px;max-height:300px;">

</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="Assets/switch.jpg" style="width:100%;min-height:300px;max-height:300px;">

</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="Assets/ps4.jpg" style="width:100%;min-height:300px;max-height:300px;">

</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div>


<div class="w3-column-paddingTop w3-row-padding w3-padding-32 w3-theme-l1" id="work">
<div class="w3-row-padding w3-center" id="pricing">
    <h2>Welcome to Maroon Gaming!</h2>
    <p>Please take a look at our various products.</p><br>
</div>





<form class="example" action="index.php" method="post">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit" name="submit" class = "submitbtn"><i class="fa fa-search"></i></button>

<br><br>
  <?php
  require_once("Backend_Models/cart.php");
  $cart = new Cart($_SESSION['username']);

  if (isset($_GET['addCartSku'])) {
    $cart->addToCart($_GET['addCartSku'], 1);
  }


  $search = '';
  if(isset($_POST['search']))  {
    $search = $_POST['search'];
  }

  $temp = dosearch($search);
  function dosearch($search){
  require_once('Database/dbAPI.php');
  $db = new dbAPI;
  if (isset($_GET['remove'])){
      $sku2 = $_GET['remove'];
      $db->removeItemfromDB($sku2);
  }
  $sku = array();
  $sku = $db->search($search);

  for($i = '0'; $i<sizeof($sku); $i++){
      $array = array();
      $array = $db->getItem($sku[$i]);
      if(is_null($array)){
        break;
      }
      echo"<div class='w3-quarter'>";
      echo"<div class='w3-card w3-white w3-margin-top w3-margin-right w3-border w3-border-red w3-padding-16'>";

    //while($results = mysqli_fetch_array($query)){
      echo"  <div class='w3-container'>";
      echo"  <h3>".$array['name']."</h3>";
      echo"  <p>".$array['description']."</p>";
      echo"  <p>".$array['priceUSD']."</p>";
        if(isset($_SESSION['type'])){
          switch ($_SESSION['type']) {
            case 'user':
              echo "<a href='index.php?addCartSku=".$array['sku']."'  class='btn add'>Add to cart</a>";
              break;
            case 'admin':
              $skuVar = $sku[$i];
              echo"<dev id='btncont'>";
              echo "<form action='index.php' method='post' id='remove'>";

              echo "<a href='index.php?remove=$skuVar' class='redbtn'>Remove Item</a>";
              //echo"</form>";



              echo "<a href='Frontend_Models/editItem.php?varSku=$skuVar' class='bluebtn'>Edit</a>";
              echo"</dev>";
              break;


          }
        }
        else{
          echo "<a href='Frontend_Models/login.php'  class='btn add'>Add to cart</a>";
        }
        echo"</div>";
        echo"</div>";
                echo "<br><br>";
      echo"</div>";
    }
}
  ?>
</form>

<p id="items"> <?php echo $temp;?> </p>

<!-- Footer -->
<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
  <h4>Follow Us</h4>
  <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a>
  <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Twitter"><i class="fa fa-twitter"></i></a>
  <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-google-plus"></i></a>
  <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-instagram"></i></a>
  <a class="w3-button w3-large w3-teal w3-hide-small" href="javascript:void(0)" title="Linkedin"><i class="fa fa-linkedin"></i></a>

  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  <p><a href="Frontend_Models/contact.php" class="w3-bar-item w3-button w3-hide-small w3-teal">Contact Us</a></p>
  <div style="position:relative;bottom:100px;z-index:1;" class="w3-tooltip w3-right">
    <span class="w3-text w3-padding w3-teal w3-hide-small">Go To Top</span>
    <a class="w3-button w3-theme" href="#myPage"><span class="w3-xlarge">
    <i class="fa fa-chevron-circle-up"></i></span></a>
  </div>
</footer>

<script>
// Script for side navigation
function w3_open() {
    var x = document.getElementById("mySidebar");
    x.style.width = "300px";
    x.style.paddingTop = "10%";
    x.style.display = "block";
}
// Close side navigation
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 5000); // Change image every 2 seconds
}

function displayitems(){
  document.getElementById("items").innerHTML = "<?php echo $temp;?>";
}
</script>

</body>
</html>
