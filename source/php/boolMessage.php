<?php
include_once 'message.php';

class boolMessage extends Message
{
	private $bool = false;

	function __construct()
	{
		# code...
	}

	public function setObject(bool $object)
	{
		$this->bool = $object;
		$this->error = false;
	}

	public function getObject() : bool
	{
		return $this->bool;
	}
}
?>