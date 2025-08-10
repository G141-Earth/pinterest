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
		$validMessage = parent::getValid();
		$error = !$message->check($validMessage);
		if($error)
		{
			return $message;
		}
		$path = parent::getAbsolutePath();
		$error = !$message->check($path);
		if($error)
		{
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
		$message = new intMessage();
		$read = $this->read();
		$error = !$message->check($read);
		if($error)
		{
			return $message;
		}
		$message->setObject($this->width*$this->height);
		return $message;
	}

	public function getWidth() : intMessage
	{
		$message = new intMessage();
		$read = $this->read();
		$error = !$message->check($read);
		if($error)
		{
			return $message;
		}
		$message->setObject($this->width);
		return $message;
	}

	public function getHeight() : intMessage
	{
		$message = new intMessage();
		$read = $this->read();
		$error = !$message->check($read);
		if($error)
		{
			return $message;
		}
		$message->setObject($this->height);
		return $message;
	}
	public function getTime() : intMessage
	{
		$message = new intMessage();
		$read = $this->read();
		$error = !$message->check($read);
		if($error)
		{
			return $message;
		}
		$message->setObject($this->time);
		return $message;
	}
}
?>