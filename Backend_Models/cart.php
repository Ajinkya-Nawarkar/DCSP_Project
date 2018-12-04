<?php
require_once(dirname(__DIR__)."/Backend_Models/errException.php");
require_once(dirname(__DIR__)."/Database/dbAPI.php");

class Cart
{
  private $username;
  private $database;

  function __construct($un)
  {
    $this->username = $un;
    $this->database = new dbAPI;
  }

  function getItems()
  {
    $data = $this->database->query("SELECT * FROM users WHERE username='$this->username'");
    $items = $data['cart'];
    echo $items;
    $cart = array();
    for ($i = 0; $i < sizeof($items); $i++) {
      if ($items[$i] != '0') {
        $cart[$i] = $items[$i];
      }
    }
    return $cart;
  }

  function getItemDetails($skus)
  {
    $items = array();
    foreach ($skus as $sku => $quant) {
      $curr_item = $this->database->getItem($sku);
      array_push($items, $curr_item);
    }
    return $items;
  }

  function addToCart($sku, $amount)
  {
    $this->database->addToCart($this->username, $sku, $amount);
  }

  function removeFromCart($sku) {
    $this->database->removeFromCart($this->username, $sku);
  }

  function editCartQuant($sku, $amount) {
    $this->database->editCartQuant($this->username, $sku, $amount);
  }
}
?>
