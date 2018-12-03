<?php
  
  require_once(dirname(__DIR__)."/Backend_Models/errExceptions.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");

  // Model class for function implementations of User class

  /*
   
   TODO: @JACK: removeAccountFromDB() to be implemented inside manageAccounts.php

   */

  class Admin
  {
    public $username;
    public $password;
    public $firstname;
    public $lastname;

    private $error; 
    private $database;

    function __construct($un, $pw, $fn, $ln)
    {
      $this->username = $un;
      $this->password = $pw;
      $this->firstname = $fn;
      $this->lastname = $ln;      

      // Initialize new objects for all required classes
      $this->error = new errExceptions;
      $this->database = new dbAPI;

      // Validate the username
      //$this->validateUsername();

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

    // Addition of a new admin to the database with its respective attributes
    function addAdminToDB()
    {
      $this->database->newAdmin($this);
    }

  }

  ?>

