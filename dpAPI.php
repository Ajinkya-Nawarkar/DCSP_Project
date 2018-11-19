<?php
class dbAPI
{
  //Database connection information
  public $hn = "pluto.cse.msstate.edu";
  public $un = "cu81";
  public $pw = "aDqhvAtAp4ny5JMr";
  public $db = "cu81";
  public $conn;


  public function __construct($hn, $un, $pw, $db){
    $this->conn = new mysqli($hn, $un, $pw, $db);
    if($conn -> connect_error)
    die($conn -> connect_error);
  }

  //Function accepts any query and returns the result.
  public function query($query){
    $conn->query($query);
    return $result;
  }

  public function newUser($user){
    $query  = "INSERT INTO users (username, password, firstname, lastname) "
            . "VALUES('$user->username', '$user->password', '$user->firstname', '$user->lastname')";
    $conn->query($query);
    return true;
  }

  public function deleteUser($username){
    $query  = "DELETE FROM users WHERE name = '$username'";
    $conn->query($query);
    return true;
  }

  public function newAdmin($admin){
    $query  = "INSERT INTO admins (username, password) "
            . "VALUES('$user->username', '$user->password)";
    $conn->query($query);
    return true;
  }

  public function deleteAdmin($username){
    $query  = "DELETE FROM admins WHERE name = '$username'";
    $conn->query($query);
    return true;
  }
  public function getItem($sku){
    $conn->query("SELECT * FROM items WHERE sku = '$sku'");
    return $result;
  }

  public function addItem($item){
    $query  = "INSERT INTO items (sku, name, platform, type, developer, description, priceUSD, quantity) "
            . "VALUES('$item->sku, $item->name, $item->platform, $item->type, $item->developer, $item->description, $item->priceUSD, $item->quantity')";
    $conn->query($query);
    return true;
  }

  public function removeItem($sku){
    $query  = "DELETE FROM items WHERE sku = '$sku'";
    $conn->query($query);
    return true;
  }

  public function editQuant($sku, $amount){
    $query  = "UPDATE items SET amount = '$amount' WHERE sku = '$sku'";
    $conn->query($query);
    return true;
  }

  public function editCartQuant($username, $sku, $amount){
    //Retrieve arrays from itemQuantity and itemList
    $itemQuantQuery = "SELECT cartItemQuant FROM users WHERE username = '$username'";
    $itemSkuQuery = "SELECT cartItem FROM users WHERE username = '$username'";

    //Find the point in which both arrays correspond and edit the itemQuantQuery
    for($i = 0; $i < sizeof($itemQuantQuery); $i++){
      if($itemSkuQuery[$i] = $sku){
        $itemQuantQuery[$i] = $amount;
      }
    }

    //Add queries to update overall inventory

    //Send an updated query using the new itemQuantQuery array
    $query  = "UPDATE users SET cartItemQuant = '$itemQuantQuery' WHERE username = '$username'";
    $conn->query($query);
    return true;
  }

  public function removeFromCart($name, $sku, $amount){
    //Retrieve arrays from itemQuantity and itemList
    $itemQuantQuery = "SELECT cartItemQuant FROM users WHERE username = '$username'";
    $itemSkuQuery = "SELECT cartItem FROM users WHERE username = '$username'";

    //Find the point in which both arrays correspond and edit the itemQuantQuery
    for($i = 0; $i < sizeof($itemQuantQuery); $i++){
      if($itemSkuQuery[$i] = $sku){
        break;
      }
    }
    //Delete occurances of the selected item
    unset($itemQuatQuery[$i]);
    unset($itemSkuQuery[$i]);

    //Add queries to update overall inventory

    //Send an updated query using the new itemQuantQuery and itemSKyQuery arrays
    $query  = "UPDATE users SET cartItemQuant = '$itemQuantQuery' WHERE username = '$username'";
    $conn->query($query);
    $query  = "UPDATE users SET cartItem = '$itemSkuQuery' WHERE username = '$username'";
    $conn->query($query);
    return true;
  }
}
