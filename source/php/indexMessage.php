<?php
include_once 'message.php';

class indexMessage extends Message
{
	private $compair = null;
	private $index = null;

	function __construct()
	{
		# code...
	}

	public function setObject($index, $compair)
	{
		if(!is_integer($index) || !is_integer($compair))
		{
			$this->setError("Attributes are incorrect in setObject function.");
			return;
		}
		$this->index = $index;
		$this->compair = $compair;
		$this->error = false;
	}

	public function getObject() : stdClass
	{
		$obj = new stdClass();
		$obj->compair = $this->compair;
		$obj->index = $this->index;
		return $obj;
	}
}
?>