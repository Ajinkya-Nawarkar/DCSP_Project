<?php
  
	require_once(dirname(__DIR__)."/Models/errExceptions.php");

  // Model class for function implementations of Item class

  class Item
  {
   	private $sku;
   	private $name;
   	private $platform;
   	private $type;
   	private $developer;
   	private $description;
   	private $priceUSD;
   	private $quantity; 

   	private $error; 

   	function __construct($sku, $name, $platform, $type, $developer, $description, $priceUSD, $quantity)
   	{
   		$this->sku = $sku;
	   	$this->name = $name;
	   	$this->platform = $platform;
	   	$this->type = $type;
	   	$this->developer = $developer;
	   	$this->description = $description;
	   	$this->priceUSD = $priceUSD;
	   	$this->quantity = $quantity; 

	   	$this->error = new errExceptions();

	   	// Validate all necessary attributes with errors exceptions
	   	$this->validateName();
	   	$this->validatePriceUSD();
	   	$this->validateQuantity();

	   	// Throw the validation errors if exists
	   	if ($this->error->hasError())
	   		throw $this->err; 
   	}

   	function getSku()			{	return $this->sku;	}
   	function getName()			{	return $this->name;	}
   	function getPlatform()		{	return $this->platform;	}
   	function getType()			{	return $this->type;	}
   	function getDescription()	{	return $this->description;	}
   	function getDeveloper()		{	return $this->developer;	}
   	function getPrice()			{	return $this->priceUSD;	}
   	function getQuantity()		{	return $this->quantity;	} 

   	function validateName()
   	{
   		// To be implemented
   	}

   	function validatePriceUSD()
   	{
   		// To be implemented
   	}

   	function validateQuantity()
   	{
   		// To be implemented
   	}

   	function removeItem()
   	{
   		// To be implemented
   	}

   	function editQuantity($sku, $num)
   	{
   		// To be implemented
   	}
  }

?>
