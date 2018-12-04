<?php

require_once(dirname(__DIR__)."/Backend_Models/user.php");

class dbAPI
{
  //Database connection information
  public $connection;


  public function __construct(){
    $hn = "pluto.cse.msstate.edu";
    $un = "cu81";
    $pw = "maroongaming";
    $db = "cu81";

    $this->connection = new mysqli($hn, $un, $pw, $db);
    if ($this->connection->connect_error) die($this->connection->connect_error);
  }

  //Function accepts any query and returns the result.
  public function query($query){
    $result = mysqli_fetch_array($this->connection->query($query));
    return $result;
  }

  public function newUser($user){
    $username = $user->getUsername();
    $password = $user->getPassword();
    $firstname = $user->getFirstname();
    $lastname = $user->getLastname();
    //Initialize a new user's cart with an array containing 50 indexes filled with 0's.
    //When a user adds an item to their cart the value at the index equal to the item's sku
    //will be changed to the amount of the item the user wants.
    $array = array();
    for($i = 0;$i < 50;$i++) {
      $array[] = $i;
      $array[$i] = 0;
    }
    $query  = "INSERT INTO users (username, password, firstname, lastname, cart) "
            . "VALUES('$username', '$password', '$firstname', '$lastname', '$array')";
    $this->connection->query($query);
    return true;
  }

  public function deleteUser($username){
    $query  = "DELETE FROM users WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }

  public function newAdmin($admin){
    $username = $admin->getUsername();
    $password = $admin->getPassword();
    $firstname = $admin->getFirstname();
    $lastname = $admin->getLastname();
    $query  = "INSERT INTO admins (username, password, firstname, lastname) "
            . "VALUES('$username', '$password', '$firstname', '$lastname')";
    $this->connection->query($query);
    return true;
  }

  public function deleteAdmin($username){
    $query  = "DELETE FROM admins WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function getItem($sku){
    $result = mysqli_fetch_array($this->connection->query("SELECT * FROM items WHERE sku = '$sku'"));
    return $result;
  }

  public function addItemToDB($item){

    $sku = $item->getSku();
    $name = $item->getName();
    $platform = $item->getPlatform();
    $type = $item->getType();
    $developer = $item->getDeveloper();
    $description = $item->getDescription();
    $priceUSD = $item->getPrice();
    $quantity = $item->getQuantity();

    $query  = "INSERT INTO items (sku, name, platform, type, developer, description, priceUSD, quantity) "
            . "VALUES('$sku', '$name', '$platform', '$type', '$developer', '$description', '$priceUSD', '$quantity')";

    $this->connection->query($query);
    return true;
  }

  public function removeItemfromDB($sku){
    $query  = "DELETE FROM items WHERE sku = '$sku'";
    $this->connection->query($query);
    return true;
  }

  public function modifyItemQuantityInDB($sku, $amount){
    $query  = "UPDATE items SET quantity = '$amount' WHERE sku = '$sku'";
    $this->connection->query($query);
    return true;
  }

  public function editCartQuant($username, $sku, $amount){
    //Retrieve arrays from items and users
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $currentInventoryQuant = mysqli_fetch_array($this->connection->query("SELECT quantity FROM items WHERE sku = '$sku'"));

    //Update overall inventory
    $updatedInventory = $cartQuery[0][$sku] - $amount;
    $updatedInventory = $currentInventoryQuant[0] + $updatedInventory;
    $query  = "UPDATE items SET quantity = '$updatedInventory' WHERE sku = '$sku'";
    $this->connection->query($query);

    //Send an updated query using the new cartQuery array
    $cartQuery[0][$sku] = $amount;
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function addToCart($username, $sku, $amount){
    //Retrieve arrays from items and users
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $currentInventoryQuant = mysqli_fetch_array($this->connection->query("SELECT quantity FROM items WHERE sku = '$sku'"));

    //Add queries to update overall inventory
    $updatedInventory = $currentInventoryQuant[0] - $amount;
    $query  = "UPDATE items SET quantity = '$updatedInventory' WHERE sku = '$sku'";
    $this->connection->query($query);

    //Send an updated query using the new cartQuery array
    $cartQuery[0][$sku] = $amount;
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function removeFromCart($username, $sku){
    //Retrieve arrays from items and users
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $currentInventoryQuant = mysqli_fetch_array($this->connection->query("SELECT quantity FROM items WHERE sku = '$sku'"));

    //Add queries to update overall inventory
    $updatedInventory = $currentInventoryQuant[0] + $cartQuery[0][$sku];
    $query  = "UPDATE items SET quantity = '$updatedInventory' WHERE sku = '$sku'";
    $this->connection->query($query);

    //Send an updated query using the new cartQuery arrays
    $cartQuery[0][$sku] = 0;
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }



  public function getAllUsers(){
    $result = query("SELECT username FROM users");
    return $result;
  }
  public function getAllAdmins(){
    $result = query("SELECT username FROM admins");
    return $result;
  }
  public function getOneUser($username){
    $array = array($username);
    $result = mysqli_fetch_array($this->connection->query("SELECT password FROM users WHERE username = '$username'"));
    array_push($array, $result[0]);
    return $array;
  }
  public function getOneAdmin($username){
    $array = array($username);
    $result = mysqli_fetch_array($this->connection->query("SELECT password FROM admins WHERE username = '$username'"));
    array_push($array, $result[0]);
    return $array;
  }

  public function search($search) {
    if ($seach == "") {
      $query = "SELECT sku FROM items";
    } else {
      $query = "SELECT sku FROM items WHERE MATCH(name, platform, type, developer, description) AGAINST('$search' IN NATURAL LANGUAGE MODE)";
    }
    $results = array();
    $data = $this->connection->query($query);
    while ($result = $data->fetch_array()) {
      array_push($results, $result['sku']);
    }
    return $results;
  }

  public function editAccount($username, $password, $firstname, $lastname){
    $query  = "UPDATE users SET password = '$password', firstname = '$firstname', lastname = '$lastname' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function editItem($sku, $name, $platform, $type, $developer, $description, $priceUSD, $quantity){
    $query  = "UPDATE items SET name = '$name', platform = '$platform', type = '$type', developer = '$developer', description = '$description', priceUSD = '$priceUSD', quantity = '$quantity' WHERE sku = '$sku'";
    $this->connection->query($query);
    return true;
  }
}
?>
