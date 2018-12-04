<?php
  
	require_once(dirname(__DIR__)."/Backend_Models/errException.php");
  require_once(dirname(__DIR__)."/Database/dbAPI.php");

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
      private $database;

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

      // Initialize the objects for the exceptions and database classes
	   	$this->error = new errExceptions;
      $this->database = new dbAPI;

	   	// Validate all necessary attributes with errors exceptions
	   	//$this->validatePriceUSD();
	   	//$this->validateQuantity();

	   	// Throw the validation errors if exists
	   	if ($this->error->hasError())
	   		throw $this->error; 
   	}

   	function getSku()			{	return $this->sku;	}
   	function getName()			{	return $this->name;	}
   	function getPlatform()		{	return $this->platform;	}
   	function getType()			{	return $this->type;	}
   	function getDescription()	{	return $this->description;	}
   	function getDeveloper()		{	return $this->developer;	}
   	function getPrice()			{	return $this->priceUSD;	}
   	function getQuantity()		{	return $this->quantity;	} 

   	function validatePriceUSD()
   	{
   		if (!is_float($this->priceUSD))
            $this->error->addError("price", "Price needs to be float");
         if ($this->priceUSD < 0)
            $this->error->addError("price", "Price must be positive and greater than or equal to 1");
   	}

   	function validateQuantity()
   	{
   		if(!is_numeric($this->quantity))
            $this->error->addError("quantity","Quantity must be numeric.");
         if($this->quantity < 0)
         $this->error->addError("quantity","Quantity must be greater than or equal to 0.");
   	}

    // Addition of a new item to the database with its respective attributes
    function addItemToDB()
    {
       $this->database->addItemToDB($this);
    }
  }

?>
