<?php
  // include the database credentials
    include("db_credentials.php");
?>

<?php
class dbAPI
{
  //Database connection information
  public $connection;


  public function __construct(){
    $this->connection = new mysqli($hn, $un, $pw, $db);
    if ($this->connection->connect_error) die($this->connection->connect_error);
  }

  //Function accepts any query and returns the result.
  public function query($query){
    $result = mysqli_fetch_array($this->connection->query($query));
    return $result;
  }

  public function newUser($user){
    //Initialize a new user's cart with an array containing 50 indexes filled with 0's.
    //When a user adds an item to their cart the value at the index equal to the item's sku
    //will be changed to the amount of the item the user wants.
    $array = array();
    for($i = 0;$i < 50;$i++) {
      $array[] = $i;
      $array[$i] = 0;
    }
    $query  = "INSERT INTO users (username, password, firstname, lastname, cart) "
            . "VALUES('$user->username', '$user->password', '$user->firstname', '$user->lastname', '$array')";
    $this->connection->query($query);
    return true;
  }

  public function deleteUser($username){
    $query  = "DELETE FROM users WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }

  public function newAdmin($admin){
    $query  = "INSERT INTO admins (username, password) "
            . "VALUES('$admin->username', '$admin->password')";
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
    $query  = "INSERT INTO items (sku, name, platform, type, developer, description, priceUSD, quantity) "
            . "VALUES('$item->sku', '$item->name', '$item->platform', '$item->type', '$item->developer', '$item->description', '$item->priceUSD', '$item->quantity')";
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
    //Retrieve arrays from itemQuantity and itemList
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $cartQuery[0][$sku] = $amount;
    //Add queries to update overall inventory

    //Send an updated query using the new cartQuery array
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function addToCart($username, $sku, $amount){
    //Retrieve arrays from itemQuantity and itemList
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $cartQuery[0][$sku] = $amount;
    //Add queries to update overall inventory

    //Send an updated query using the new cartQuery array
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  public function removeFromCart($username, $sku){
    //Retrieve arrays from itemQuantity and itemList
    $cartQuery = mysqli_fetch_array($this->connection->query("SELECT cart FROM users WHERE username = '$username'"));
    $cartQuery[0][$sku] = 0;
    //Add queries to update overall inventory

    //Send an updated query using the new cartQuery arrays
    $query  = "UPDATE users SET cart = '$cartQuery' WHERE username = '$username'";
    $this->connection->query($query);
    return true;
  }
  
  public function search($search) {
    $query = "SELECT sku FROM items WHERE MATCH(name, platform, type, developer, description) AGAINST($search IN NATURAL LANGUAGE MODE)";
    $results = array();
    while ($result = mysqli_fetch_array($query)) {
      array_push($results, $result['sku']);
    }
    return $results;
  }
}
?>
