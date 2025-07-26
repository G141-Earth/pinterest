<?php
include_once 'stringMessage.php';
include_once 'boolMessage.php';


abstract class Path
{
	protected $root = null;
	protected $directory = null;
	protected $name = null;
	protected $valid = false;
	protected $mime = null;

	function __construct($path, $index)
	{
		if(!is_string($path) || !is_numeric($index))
			return;
		$path = strtolower($path);
		$segments = explode('/', $path);
		if($index < 0 || $index > count($segments))
			return;
		$this->valid = file_exists($path);
		if(!$this->valid)
			return;
		$this->mime = mime_content_type($path);
		$this->root = implode('/', array_slice($segments,0,$index));
		$directory = array_slice($segments,$index);
		if(strcmp($this->mime, "directory") != 0)
			unset($directory[count($directory)-1]);
		$this->name = $segments[count($segments)-1];
		$this->directory = implode('/', $directory);
	}

	abstract public function getName() : stringMessage;

	abstract public function getDirectory() : stringMessage;

	abstract public function getRelativePath() : stringMessage;

	abstract public function getAbsolutePath() : stringMessage;

	public function is_valid()
	{
		return $this->valid;
	}

	public function is_image() : boolMessage
	{
		$message = new boolMessage();
		if(!$this->valid)
		{
			$message->setError('Path is not valid.');
			return $message;
		}
		$message->setObject(str_starts_with($this->mime, 'image'));
		return $message;
	}

	abstract protected function validates() : boolMessage;

	abstract public function equals($obj) : boolMessage;
}
?>