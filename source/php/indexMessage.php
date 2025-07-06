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

	public function setObject($object)
	{
		if(is_a($object,'stdClass') && isset($object->index) && isset($object->comapir))
		{
			{
			$this->setError("Attribut is not stdClass with index and compair parameters.");
			return;
		}
		}
		if(!is_integer($object->index) || !is_integer($object->compair))
		{
			$this->setError("Parameters are incorrect in setObject function.");
			return;
		}
		$this->index = $object->index;
		$this->compair = $object->compair;
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