<?php
include_once 'boolMessage.php';
include_once 'stringMessage.php';
class leaf2
{
	private bool $valid;
	protected bool $read;
	private string $mime;
	private string $folder;
	private string $root;
	static private $array;
	
	function __construct(string $path, int $index)
	{
		$this->valid = file_exists($path);
		if(!$this->valid || $index < 0)
		{return;}
		$info = pathinfo($path);
		$array = explode('/', $info['dirname']);
		$this->root = implode('/', array_slice($array,0,$index));
		$this->folder = implode('/', array_slice($array,$index));
		$this->name = $info['basename'];
		$this->mime = mime_content_type($path);
		$this->read = false;
	}

	public function getValid() : boolMessage
	{
		$message = new stringMessage();
		$message->setObject($this->valid);
		return $message;
	}

	public function getMime() : stringMessage
	{
		$message = new stringMessage();
		if(isset($this->mime))
		{
			$message->setObject($this->mime);
		}
		else
		{
			$message->setError("Mime is not setted");
		}
		return $message;
	}

	public function getName() : stringMessage
	{
		$message = new stringMessage();
		if(isset($this->name))
		{
			$message->setObject($this->name);
		}
		else
		{
			$message->setError("Name is not setted");
		}
		return $message;
	}

	public function getAbsolutePath() : stringMessage
	{
		$relative = $this->getRelativePath();
		if(!$relative->is_success())
		{return $relative;}
		$message = new stringMessage();
		if(!isset($this->root))
		{
			$message->setError("properties are not setted");
			return $message;
		}
		$message->setObject($this->root.'/'.$relative->getObject());
		return $message;
	}

	public function getRelativePath() : stringMessage
	{
		$message = new stringMessage();
		if(!isset($this->folder) || !isset($this->name))
		{
			$message->setError("properties are not setted");
			return $message;
		}
		$array = [];
		if(!empty($this->folder))
			array_push($array, $this->folder);
		array_push($array, $this->name);
		$message->setObject(implode('/', $array));
		return $message;
	}

	public function read() : boolMessage
	{
		$message = new boolMessage();
		$message->setError('Nothing readable there');
		return $message;
	}

	static public function add(string $extension, string $group) : void
	{
		self::$array = self::val();
		self::$array[$extension] = $group;
		//add('jpg', 'image');
	}

	static public function val() : Array
	{
		return !isset(self::$array) ? [] : self::$array;
	}
}

?>