<?php
include_once 'boolMessage.php';
include_once 'stringMessage.php';
include_once 'intMessage.php';
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
		$this->name = strtolower($info['basename']);
		$this->mime = mime_content_type($path);
		$this->read = false;
	}

	public function getValid() : boolMessage
	{
		$message = new boolMessage();
		$message->setObject($this->valid);
		return $message;
	}

	public function getMime(bool $compair=false) : stringMessage
	{
		$message = new stringMessage();
		if(!isset($this->mime))
		{
			$message->setError("Mime is not setted");
			return $message;
		}
		$message->setObject($this->mime);
		if(!$compair) { return $message; }
		$array = explode('.', $this->name);
		if(count($array)<2) { return $message; }
		$index = $array[count($array)-1];
		$array = self::val();
		if(isset($array[$index]))
		{
			$message->setObject($array[$index]);
			return $message;
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

	public function getRootIndex() : intMessage
	{
		$message = new intMessage();
		if(!isset($this->root))
		{
			$message->setError("Root is not setted");
			return $message;
		}
		$array = explode('/', $this->root);
		$message->setObject(count($array));
		return $message;
	}

	public static function sort($b, $a) : bool
	{
		return self::compair($b,$a)>0;
	}

	public static function compair($b,$a) : int
	{
		$mimeA = $a->getMime(true)->getObject();
		$mimeB = $b->getMime(true)->getObject();
		$A = strcmp($mimeA, "directory") == 0 ? 0 : (str_starts_with($mimeA, "image") ? 1 : 2);
		$B = strcmp($mimeB, "directory") == 0 ? 0 : (str_starts_with($mimeB, "image") ? 1 : 2);
		if($A==$B && $A != 2)
		{
			return strcmp($b->getName()->getObject(), $a->getName()->getObject());
		}
		else if($A==$B && $A == 2)
		{
			return strcmp($mimeB, $mimeA);
		}
		return $B-$A;
		
	}
}

?>