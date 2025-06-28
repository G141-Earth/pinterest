<?php
include_once 'path.php';
include_once 'stringMessage.php';
include_once 'boolMessage.php';
include_once 'quiksort.php';

class Folder extends Path
{
	private $read = false;
	private $content = [];

	function __construct($path, $index)
	{
		if(!is_string($path))
			return;
		parent::__construct($path, $index);
		$v = $this->validates();
		$this->valid = $v->getObject();
	}

	public function read() : boolMessage
	{
		$message = new boolMessage();
		if($this->read)
		{
			$message->setError("Folder is already read.");
			return $message;
		}
		$path = $this->getAbsolutePath();
		if(!$path->is_success())
		{
			$message->setError($path->getMessage());
			return $message;
		}
		$directory = scandir($path->getObject());
		$directory = array_slice($directory, 2);
		//sort($directory, SORT_STRING | SORT_FLAG_CASE);
		$fun = function($a,$b) {return strcmp(strtolower($a), strtolower($b))<0;};
		quickSort($directory,0,count($directory)-1,$fun);
		var_dump($directory);
		$this->read=true;
		$message->setObject(true);
		return $message;
	}

	public function getName() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("Folder is not valid");
			return $message;
		}
		$message->setObject($this->name);
		return $message;
	}

	public function getDirectory() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("File is not valid");
			return $message;
		}
		$message->setObject($this->directory);
		return $message;
	}

	public function getRelativePath() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("Folder is not valid");
			return $message;
		}
		$path = [];
		if(!empty($this->directory))
			array_push($path, $this->directory);
		$message->setObject(implode('/', $path));
		return $message;
	}

	public function getAbsolutePath() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("Folder is not valid");
			return $message;
		}
		$message->setObject(empty($this->directory) ? $this->root : implode('/', [$this->root, $this->directory]));
		return $message;
	}

	protected function validates() : boolMessage
	{
		$message = new boolMessage();
		if(!$this->is_valid())
		{
			$message->setError("Folder is not valid.");
			return $message;
		}
		if(!is_dir($this->getAbsolutePath()->getObject()))
		{
			$message->setError("Folder is not a Folder.");
			return $message;
		}
		$message->setObject(true);
		return $message;
	}

	public function equals($obj) : boolMessage
	{
		$message = new boolMessage();
		if(!is_a($obj, get_class($this)))
		{
			$message->setError("Object is not a folder.");
			return $message;
		}
		if(strcmp($this->getAbsolutePath(),$obj->getAbsolutePath()) == 0)
		{
			$message->setError("Object is not same folder.");
			return $message;
		}
		if(!$this->is_valid())
		{
			$message->setError("Folder is not valid.");
			return $message;
		}
		if(!$obj->is_valid())
		{
			$message->setError("Object is not valid.");
			return $message;
		}
		$message->setObject(true);
		return $message;
	}
}
?>