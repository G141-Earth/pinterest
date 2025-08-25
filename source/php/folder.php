<?php
include_once 'boolMessage.php';
include_once 'intMessage.php';
include_once 'leaf-2.php';
include_once 'factory.php';
include_once 'quicksort.php';

class Folder extends Leaf2
{
	private Array $content;

	function __construct($path, $index)
	{
		parent::__construct($path, $index);
	}

	#Override
	public function read() : boolMessage
	{
		$message = new boolMessage();
		$validMessage = parent::getValid();
		$error = !$message->check($validMessage);
		if($error)
			return $message;
		if($this->read)
		{
			$message->setError('Already read folder');
			$message->setObject(true);
			return $message;
		}
		$path = parent::getAbsolutePath();
		$error = !$message->check($path);
		if($error){ return $message; }
		$path = $path->getObject();
		$this->content = array_slice(scandir($path), 2);
		sort($this->content, SORT_STRING | SORT_FLAG_CASE);
		/*
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
			$l = Factory::create('leaf2', $path.'/'.$c,$index);
			return $l;
		};
		Leaf2::add('pdf','document');
		Leaf2::add('txt','note');
		$this->content = array_map($fun, $this->content);
		usort($this->content, array("Leaf2", "sort"));
		$this->content = array_map(array("Factory", "evolve"), $this->content);
		$test = false;
		if($test) 
		{
			foreach ($this->content as $key => $value)
			{
				echo get_class($value)." ** ".$value->getMime(true)->getObject()."*".$value->getName()->getObject();
				echo "<hr>";
			}
		}
		*/
		$this->read = true;
		$message->setObject(true);
		return $message;
	}

	public function getContent() : Array
	{
		$m = $this->read();
		if(!$m->is_success())
		{ return []; }
		else if(!isset($this->content))
		{ return []; }
		return $this->content;
	}
}
?>