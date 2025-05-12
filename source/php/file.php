<?php
include_once 'path.php';
include_once 'stringMessage.php';
include_once 'boolMessage.php';

class File extends Path
{
	function __construct($path, $index)
	{
		if(!is_string($path))
			return;
		parent::__construct($path, $index);
		$v = $this->validates();
		$this->valid = $v->getObject();
	}

	public function getName() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("File is not valid");
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
			$message->setError("File is not valid");
			return $message;
		}
		$path = [];
		if(!empty($this->directory))
			array_push($path, $this->directory);
		array_push($path, $this->name);
		$message->setObject(implode('/', $path));
		return $message;
	}

	public function getAbsolutePath() : stringMessage
	{
		$message = new stringMessage();
		if(!$this->is_valid())
		{
			$message->setError("File is not valid");
			return $message;
		}
		$path = [];
		if(!empty($this->root))
			array_push($path, $this->root);
		if(!empty($this->directory))
			array_push($path, $this->directory);
		array_push($path, $this->name);
		$message->setObject(implode('/', $path));
		return $message;
	}

	protected function validates() : boolMessage
	{
		$message = new boolMessage();
		if(!$this->is_valid())
		{
			$message->setError("File is not valid.");
			return $message;
		}
		if(!is_file($this->getAbsolutePath()->getObject()))
		{
			$message->setError("File is not a file.");
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
			$message->setError("Object is not a file.");
			return $message;
		}
		if(strcmp($this->getAbsolutePath(),$obj->getAbsolutePath()) == 0)
		{
			$message->setError("Object is not same file.");
			return $message;
		}
		if(!$this->is_valid())
		{
			$message->setError("File is not valid.");
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