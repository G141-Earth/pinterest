<?php
include_once 'message.php';
include_once 'leaf-2.php';

class LeafMessage extends Message
{
	private Leaf2 $leaf;

	function __construct()
	{
		# code...
	}

	public function setObject($object)
	{
		if(!is_a($object,'Leaf2'))
		{
			$this->setError("Attribut is not a Leaf");
			return;
		}
		$this->leaf = $object;
		$this->error = false;
	}

	public function getObject() : Leaf2
	{
		return $this->leaf;
	}
}
?>