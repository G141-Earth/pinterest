<?php
include_once 'boolMessage.php';
include_once 'intMessage.php';
include_once 'leaf-2.php';
include_once 'quicksort.php';

class Folder extends Leaf2
{
	private Array $content;
	private int $width;
	private int $height;
	private int $size;

	function __construct($path, $index)
	{
		parent::__construct($path, $index);
	}

	#Override
	public function read() : boolMessage
	{
		$message = new boolMessage();
		if($this->read)
		{
			$message->setError('Already read folder');
			$message->setObject(true);
			return $message;
		}
		$path = parent::getAbsolutePath();
		$index = parent::getRootIndex();
		if(!$path->is_success())
		{
			$message->setError($path->getMessage());
			return $message;
		}
		$path = $path->getObject();
		if(!$index->is_success())
		{
			$message->setError($index->getMessage());
			return $message;
		}
		$index = $index->getObject();
		$this->content = array_slice(scandir($path), 2);
		$fun = function ($c) use ($path, $index)
		{
			$l = new Leaf2 ($path.'/'.$c,$index);
			return $l;
		};
		Leaf2::add('pdf','document');
		Leaf2::add('txt','note');
		$this->content = array_map($fun, $this->content);
		usort($this->content, array("Leaf2", "sort"));
		foreach ($this->content as $key => $value) {
			echo $value->getMime(true)->getObject()."*".$value->getName()->getObject();
			echo "<hr>";
		}

		$this->read = true;
		$message->setObject(true);
		return $message;
	}
}
?>