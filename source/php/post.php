<?php

/**
 * 
 */

include_once 'boolMessage.php';
include_once 'factory.php';
include_once 'stringMessage.php';

class post
{
	private int $id;
	private int $time;
	private int $pinned;
	private string $name;
	private string $description;
	private string $link;
	private string $relativePath;
	private File $file;

	function __construct()
	{
		# code...
	}

	public function getName() : stringMessage
	{
		$message = new stringMessage();
		if(!isset($this->relativePath))
		{
			$message->setError("Name is not setted.");
			return $message;
		}
		$array = explode('/', $this->relativePath);
		$last = $array[count($array)-1];
		$message->setObject($last);
		return $message;
	}

	public function addId(int $id) : boolMessage
	{
		$message = new boolMessage();
		if($id<1)
		{
			$message->setError('Id is less than 1');
			return $message;
		}
		$this->id = $id;
		$message->setObject = true;
		return $message;
	}

	public function addPinnedState(int $p) : boolMessage
	{
		$message = new boolMessage();
		if($p<1)
		{
			$message->setError('State was less than 1');
			$p = 0;
		}
		$this->pinned = $p;
		$message->setObject = true;
		return $message;
	}

	public function addDescription(?string $description) : boolMessage
	{
		$message = new boolMessage();
		if(is_null($description))
		{
			$description = "";
		}
		$this->description = $description;
		$message->setObject = true;
		return $message;
	}

	public function addLink(?string $link) : boolMessage
	{
		//Format check
		$message = new boolMessage();
		if(is_null($link))
		{
			$link = "";
		}
		$this->link = $link;
		$message->setObject = true;
		return $message;
	}

	public function addRelativePath(string $path) : boolMessage
	{
		$message = new boolMessage();
		$this->relativePath = $path;
		$message->setObject = true;
		return $message;
	}

	public function addAlias(?string $alias) : boolMessage
	{
		$message = new boolMessage();
		if(is_null($alias))
		{
			$alias = "";
		}
		$this->name = $alias;
		$message->setObject = true;
		return $message;
	}

	public function fileMaker() : boolMessage
	{
		$message = new boolMessage();
		$try = Factory::create('file', '../libary/'.$this->relativePath, 2);
		$error = !$message->check($try);
		if($error)
		{ return $message; }
		$this->file = $try->getObject();
		return $this->file->getValid();
	}

	public function getFile() : File
	{
		return $this->file;
	}

	public function getTime() : intMessage
	{
		$message = new intMessage();
		if(isset($this->time))
		{
			$message->getObject($this->time);
			return $message;
		}
		$time = $this->file->getTime()->getObject();
		return $message;
	}

	public function addTime($time) : boolMessage
	{
		$message = new boolMessage();
		if(!is_int($time) && is_string($time))
		{
			$try = strtotime($time);
			if(is_int($try))
			{
				$time = $try;
			}
			else
			{
				$message->setError("Format is not valid");
				return $message;
			}
		}
		else if(!is_int($time))
		{
			$message->setError("Attribute is not string or int");
			return $message;
		}
		$this->time = $time;
		$message->setObject = true;
		return $message;
	}
}

?>