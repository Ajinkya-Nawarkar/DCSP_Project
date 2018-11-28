<?php

// Model to handle all types of exceptions 

class errExceptions extends Exception
{
	private $errMap;
	private $errPresent;

	function __contruct($exceptionItem = NULL, $code = 0, Exception $previous = null)
	{
		$this->errPresent = false;
		$this->errMap = array();
		if(isset($exceptionItem))
			switch(gettype($exceptionItem))
			{
				case "array":
					if(count($exceptionItem) == 1)
						$this->addErr($exceptionItem[0]);
					else
						$this->addErr($exceptionItem[0],$exceptionItem[1]);
					break;
				case "string":
					$this->addErr($exceptionItem);
					break;
				default:
					throw new errExeptions(["type","Type error in errException: Expected string, array, or NULL, got " . gettype($exceptionItem)]);
					break;
			}
		parent::__construct("", $code, $previous);
		
	}

	// Returns stored errors
	function getErrArray()
	{		
		return $this->errArray;
	}

	// Adds an error. Overwrites previous errors of same key
	function addErr($key, $value = "")
	{
		$this->errMap[$key] = $value;
		$this->errPresent = true;
	}

	// Returns whether an error has been stored	
	function hasErr()
	{
		return $this->errPresent;
	}

	// Returns a formatted string showing all stored errors
	function getString(){
		$string = "";
		foreach($this->errMap as $error => $msg)
			$string .= $error . " error: " . $msg . "<br>";
		return $string;
	}
}

?>