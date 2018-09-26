<!DOCTYPE html>
<html>
<head>
  <title>User</title>
</head>
<body>
  <?php
  class User
  {
    public $username;
    private $password;
    public $cart;

    //constructor
    public function __construct($un, $pw, $c)
    {
      $this->username = $un;
      $this->password = $pw;
      $this->cart = $c;
    }

    public function addToCart($item, $q)
    {
      $this->cart[$item] = $q;
    }

    public function removeFromCart($item)
    {
      unset($this->cart[$item]);
    }

  }

  ?>
</body>
</html>
