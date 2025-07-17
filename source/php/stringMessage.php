<?php
include_once 'message.php';

class stringMessage extends Message
{
	private string $string = "";

	function __construct()
	{
		# code...
	}

	public function setObject($object)
	{
		if(!is_string($object))
		{
			$this->setError("Object is not a string in setObject function.");
			return;
		}
		$this->string = $object;
		$this->error = false;
	}

	public function getObject() : string
	{
		return $this->string;
	}
}
?>