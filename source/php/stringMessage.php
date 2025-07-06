<?php
include_once 'message.php';

class stringMessage extends Message
{
	private $string = "";

	function __construct()
	{
		# code...
	}

	public function setObject(string $object)
	{
		$this->string = $object;
		$this->error = false;
	}

	public function getObject() : string
	{
		return $this->string;
	}
}
?>