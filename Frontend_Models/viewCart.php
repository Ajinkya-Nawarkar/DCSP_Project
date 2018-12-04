<?php
session_start();
?>

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
        #view_cart {
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

        #cart {
          width:60%;
          border-collapse:collapse;
        }

        #cart tr:nth-child(even){background-color: #f2f2f2;}

        #cart th {
          padding-top: 10px;
          padding-bottom: 10px;
          background-color: #000000;
          color:white;
        }

        #cart td {
          padding-top: 5px;
          padding-bottom: 3px;
          text-align:center;
        }
    </style>
</head>
    <body>
      <?php
      require_once(dirname(__DIR__)."/Backend_Models/cart.php");

      // Only users allowed on this page
      if ($_SESSION['type'] != "user") {
        redirectUser();
      }

      // Initalize cart
      $username = $_SESSION['username'];
      $cart = new Cart($username);

      // Check if any updates had been made to the cart and update the users cart accordingly
      /*if (isset($_POST['update']) or isset($_POST['checkout'])) {
        for ($sku = 0; $sku < 50; $sku++) {
          $q = 'quant'.$sku;
          $rem = 'remove'.$sku;
          if (isset($_POST[$q])) {
            $quant = $_POST[$q];
            if ($quant == 0) {
              $cart->removeFromCart($sku);
            } else {
              $cart->editCartQuant($sku, $quant);
            }
          }
          if (isset($_POST[$rem])) {
            $cart->removeFromCart($sku);
          }
        }
      }

      // If they checkedout, redirect them to checkout.php
      if (isset($_POST['checkout'])){
        header('Location: checkout.php');
        exit();
      }

      // Get cart quantities [sku=>quant] and cart details ['sku'=>sku, 'name'=>name, etc...]
      $cart_quants = $cart->getItems();

      $empty = False;
      if (sizeof($cart_quants) == 0) {
        $empty = True;
      } else {
        $cart_all = $cart->getItemsDetails($cart_quants);
      }*/

      ?>

      <div class="w3-top">
          <div class="w3-bar w3-theme-d2 w3-left-align">

              <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
              <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
          </div>
      </div>
      <div align="center" id="view_cart">
        <div class="container">
            <div id="view_cart-row" class="row justify-content-center align-items-center">
                <div id="view_cart-column" class="col-md-6">
                    <div class="view_cart-box col-md-12">
                    <form id="view_cart-form" class="form" action='viewCart.php' method='post'>
                      <h2 class="text-center text-info"><b><?php echo $username; ?>'s Cart</b></h2><br>
                      <table id="cart">
                        <colgroup>
                           <col span="1" style="width: 10%;">
                           <col span="1" style="width: 60%;">
                           <col span="1" style="width: 10%;">
                           <col span="1" style="width: 10%;">
                           <col span="1" style="width: 10%;">
                        </colgroup>
                        <tr><th class="text-info"><b>SKU</b></th><th class="text-info"><b>Name</b></th><th class="text-info"><b>Price</b></th><th class="text-info"><b>Quantity</b></th><th class="text-info"><b>Remove</b></th></tr>
                        <?php
                        /*for ($i = 0; $i < sizeof($cart_all); $i++) {
                          if (sizeof($cart_quants) == 0) {
                            echo "<tr><td></td><td>Empty Cart</td><td></td><td></td><td></td></tr>";
                          } else {
                            echo "<tr><td>".$cart_all[$i]['sku']."</td><td>".$cart_all[$i]['name']."</td><td>".$cart_all[$i]['priceUSD']."</td>";
                            echo "<td><input type='number' name='quant".$cart_all[$i]['sku']."' min='0' max='".$cart_all[$i]['quantity']."' value='".$cart_quants[$cart_all[$i]['sku']]."' required></td>";
                            echo "<td><input type='checkbox' name='remove".$cart_all[$i]['sku']."'></td></tr>";
                          }
                        }*/
                        ?>
                        <tr style="background-color:#ffffff"><td></td><td></td><td></td><td></td><td style="vertical-align:middle"><input style="background-color: #4CAF50; color: white" type='submit' name='update' value='Update'></td></tr>
                      </table><br>
                      <input style="margin-left:50%" class="w3-bar-item w3-button w3-teal" type='submit' name='checkout' value='Checkout'>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>


    </body>
</html>
<?php
    // redirect user to index.php
    function redirectUser()
    {
        header('.Location: ../index.php');
        exit();
    }
?>
