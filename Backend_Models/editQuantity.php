<?php

	// Model for edit Quantity class function implementations
	
	require_once(dirname(__DIR__)."/Backend_Models/errExceptions.php");
	require_once(dirname(__DIR__)."/Backend_Models/item.php");
  	require_once(dirname(__DIR__)."/Database/dbAPI.php");

	class editQuantity
	{
		private $error; 
    	private $database;

    	function __construct()
    	{
	      // Initialize new objects for all required classes
	      $this->error = new errExceptions;
	      $this->database = new dbAPI;
	  	}

		// Addition of a new item to the database as an admin
		function addItemToDB($item)
		{
		  $item->addItemToDB();
		}

		// Removal of an existing item from the database as an admin
		function removeItemfromDB($sku)
		{
		  $this->database->removeItemfromDB($sku);
		}

		function modifyItemQuantityInDB($sku, $quantity)
		{
			$this->database->editQuantity($sku, $quantity);
		}
	}

?>