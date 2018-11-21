<?php
class dbAPI
{
  //Database connection information
  public $conn;


  public function __construct(){
    $hn = "pluto.cse.msstate.edu";
    $un = "cu81";
    $pw = "aDqhvAtAp4ny5JMr";
    $db = "cu81";
    $this->conn = new mysqli($hn, $un, $pw, $db);
    if ($this->conn->connect_error) die($this->conn->connect_error);
  }

  //Function accepts any query and returns the result.
  public function query($query){
    $result = $this->conn->query($query);
    return $result;
  }

  public function newUser($user){
    $query  = "INSERT INTO users (username, password, firstname, lastname, cartItem, cartItemQuant) "
            . "VALUES('$user->username', '$user->password', '$user->firstname', '$user->lastname', '$user->cartItem')";
    $this->conn->query($query);
    return true;
  }

  public function deleteUser($username){
    $query  = "DELETE FROM users WHERE username = '$username'";
    $this->conn->query($query);
    return true;
  }

  public function newAdmin($admin){
    $query  = "INSERT INTO admins (username, password) "
            . "VALUES('$user->username', '$user->password')";
    $this->conn->query($query);
    return true;
  }

  public function deleteAdmin($username){
    $query  = "DELETE FROM admins WHERE username = '$username'";
    $this->conn->query($query);
    return true;
  }
  public function getItem($sku){
    $result = $this->conn->query("SELECT * FROM items WHERE sku = '$sku'");
    return $result;
  }

  public function addItem($item){
    $query  = "INSERT INTO items (sku, name, platform, type, developer, description, priceUSD, quantity) "
            . "VALUES('$item->sku', '$item->name', '$item->platform', '$item->type', '$item->developer', '$item->description', '$item->priceUSD', '$item->quantity')";
    $this->conn->query($query);
    return true;
  }

  public function removeItem($sku){
    $query  = "DELETE FROM items WHERE sku = '$sku'";
    $this->conn->query($query);
    return true;
  }

  public function editQuant($sku, $amount){
    $query  = "UPDATE items SET quantity = '$amount' WHERE sku = '$sku'";
    $this->conn->query($query);
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
    $this->conn->query($query);
    return true;
  }
  public function addCart($username, $sku, $amount){
    //Retrieve arrays from itemQuantity and itemList
    $itemQuantQuery = "SELECT cartItemQuant FROM users WHERE username = '$username'";
    $itemSkuQuery = "SELECT cartItem FROM users WHERE username = '$username'";

    //Add item and item quatitiy to corresponding arrays
    array_push($itemQuantQuery,"$amount");
    array_push($itemSkuQuery,"$sku");
    //Add queries to update overall inventory

    //Send an updated query using the new itemQuantQuery and itemSKyQuery arrays
    $query  = "UPDATE users SET cartItemQuant = '$itemQuantQuery' WHERE username = '$username'";
    $this->conn->query($query);
    $query  = "UPDATE users SET cartItem = '$itemSkuQuery' WHERE username = '$username'";
    $this->conn->query($query);
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
    unset($itemQuantQuery[$i]);
    unset($itemSkuQuery[$i]);

    //Add queries to update overall inventory

    //Send an updated query using the new itemQuantQuery and itemSKyQuery arrays
    $query  = "UPDATE users SET cartItemQuant = '$itemQuantQuery' WHERE username = '$username'";
    $this->conn->query($query);
    $query  = "UPDATE users SET cartItem = '$itemSkuQuery' WHERE username = '$username'";
    $this->conn->query($query);
    return true;
  }
}
?>
