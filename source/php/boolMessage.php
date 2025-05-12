<?php
include_once 'message.php';

class boolMessage extends Message
{
	private $bool = false;

	function __construct()
	{
		# code...
	}

	public function setObject($object)
	{
		if(!is_bool($object))
		{
			$this->setError("Object is not a boolean in setObject function.");
			return;
		}
		$this->bool = $object;
		$this->error = false;
	}

	public function getObject() : bool
	{
		return $this->bool;
	}
}
?>