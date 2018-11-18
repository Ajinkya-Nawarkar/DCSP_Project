<?php
  
  require_once(dirname(__DIR__)."/Backend_Models/errExceptions.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");
  require_once(dirname(__DIR__)."/Frontend_Models/cart.php");

  // Model class for function implementations of User class

  class User
  {
    private $username;
    private $password;
    private $firstname;
    private $lastname;

    private $error; 
    private $database;
    private $cart;

    function __construct($un, $pw, $cart)
    {
      $this->username = $un;
      $this->password = $pw;
      $this->cart = $cart;

      // Initialize new objects for all required classes
      $this->error = new errExceptions;
      $this->database = new dbAPI;
      $this->cart = new cart;

      // Validate the username
      $this->validateUsername();

      // Throw the validation errors if exists
      if ($this->error->hasError())
        throw $this->error; 
    }

    function validateUsername()
    {
      if (strlen($this->username < 4))
        $this->error->addError("username","Username length must be greater than 3 characters.");

      if(!ctype_alnum($this->username))
        $this->errs->addErr("username","Username must contain alphanumeric characters only.");
    }

    // Addition of a new user to the database with its respective attributes
    function addUserToDB()
    {
      $this->database->newUser($this);
    }

    // Addition of a new item to the current user's cart
    function addToUserCart($sku, $quantity)
    {
      $this->database->addToCart($this->username, $sku, $quantity);
    }

    // Removal of an existing item from the current user's cart
    function removeFromUserCart($sku)
    {
      $this->database->removeFromCart($this->username, $sku);
    }

  }

  ?>

