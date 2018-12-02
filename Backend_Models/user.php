<?php
  
  require_once(dirname(__DIR__)."/Backend_Models/errException.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");
  //require_once(dirname(__DIR__)."/Frontend_Models/cart.php");

  // Model class for function implementations of User class

  /*

  TODO: @JACK You can just add these functions to cart.php 

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
  */

  class User
  {
    private $username;
    private $password;
    private $firstname;
    private $lastname;

    private $error; 
    private $database;

    function __construct($un, $pw, $fn, $ln)
    {
      $this->username = $un;
      $this->password = $pw;
      $this->firstname = $fn;
      $this->lastname = $ln;

      // Initialize new objects for all required classes
      $this->error = new errExceptions();
      $this->database = new dbAPI;

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
        $this->error->addError("username","Username must contain alphanumeric characters only.");
    }

    // Addition of a new user to the database with its respective attributes
    function addUserToDB()
    {
      $this->database->newUser($this);
    }

  }

  ?>

