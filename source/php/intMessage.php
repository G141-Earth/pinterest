<?php
include_once 'message.php';

class intMessage extends Message
{
	private int $int;

	function __construct()
	{
		# code...
	}

	public function setObject($object)
	{
		if(!is_int($object))
		{
			$this->setError("Attribut is not integer.");
			return;
		}
		$this->int = $object;
		$this->error = false;
	}

	public function getObject() : int
	{
		return $this->int;
	}
}
?>