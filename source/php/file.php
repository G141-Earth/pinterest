<?php
include_once 'boolMessage.php';
include_once 'intMessage.php';
include_once 'leaf-2.php';

class File extends Leaf2
{
	private int $time;
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
			$message->setError('Already read file');
			$message->setObject(true);
			return $message;
		}
		$path = parent::getAbsolutePath();
		if(!$path->is_success())
		{
			$message->setError($path->getMessage());
			return $message;
		}
		$this->time = filemtime($path->getObject());
		$size = getimagesize($path->getObject());
		if(is_array($size))
		{
			$this->width = $size[0];
			$this->height = $size[1];
		}
		else
		{
			$this->width = 0;
			$this->height = 0;
		}
		$this->read = true;
		$message->setObject(true);
		return $message;
	}

	public function getSize() : intMessage
	{
		$read = $this->read();
		$message = new intMessage();
		if(!$read->is_success())
		{
			$message->setError($read->getMessage());
			return $message;
		}
		$message->setObject($this->width*$this->height);
		return $message;
	}

	public function getWidth() : intMessage
	{
		$read = $this->read();
		$message = new intMessage();
		if(!$read->is_success())
		{
			$message->setError($read->getMessage());
			return $message;
		}
		$message->setObject($this->width);
		return $message;
	}

	public function getHeight() : intMessage
	{
		$read = $this->read();
		$message = new intMessage();
		if(!$read->is_success())
		{
			$message->setError($read->getMessage());
			return $message;
		}
		$message->setObject($this->height);
		return $message;
	}
	public function getTime() : intMessage
	{
		$read = $this->read();
		$message = new intMessage();
		if(!$read->is_success())
		{
			$message->setError($read->getMessage());
			return $message;
		}
		$message->setObject($this->time);
		return $message;
	}
}
?>