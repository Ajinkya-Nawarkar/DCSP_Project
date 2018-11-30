<?php
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
      require_once(dirname(__DIR__)."/Backend_Models/cart.php");

      // Only users allowed on this page
      if ($_SESSION['type'] != "user") {
        redirectUser();
      }

      // Initalize cart
      $username = $_SESSION['username'];
      $cart = new Cart($username);

      // Check if any updates had been made to the cart and update the users cart accordingly
      if (isset($_POST['update']) or isset($_POST['checkout'])) {
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
      $cart_all = $cart->getItemsDetails($cart_quants);
      ?>

      <form action='view_cart.php' method='post'>
        <h2><?php $username ?>'s Cart</h2><br>
        <table>
          <tr><th>SKU</th><th>Name</th><th>Price</th><th>Quantity</th><th>Remove</th></tr>
          <?php
          for ($i = 0; $i < sizeof($cart_all); $i++) {
            echo "<tr><td>".$cart_all[$i]['sku']."</td><td>".$cart_all[$i]['name']."</td><td>".$cart_all[$i]['priceUSD']."</td>";
            echo "<td><input type='number' name='quant".$cart_all[$i]['sku']."' min='0' max='".$cart_all[$i]['quantity']."' value='".$cart_quants[$cart_all[$i]['sku']]."' required></td>";
            echo "<td><input type='checkbox' name='remove".$cart_all[$i]['sku']."'></td></tr>";
          }
          ?>
          <tr><td></td><td></td><td></td><td></td><td><input type='submit' name='update' value='Update'></td>
        </table><br>
        <input type='submit' name='checkout' value='Checkout'>
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
