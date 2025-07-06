<?php
include_once 'quicksort.php';
include_once 'search.php';
/**
 * 
 */
class leaf
{
	private $valid = false;
	private $mime = null;
	private $name = null;
	static private $array = null;
	
	function __construct($directory, $name)
	{
		if(!(is_string($directory) && is_string($name)) || empty($name))
		{ return; }
		$array = [];
		$directory = strtolower($directory);
		$name = strtolower($name);
		if(!empty($directory))
			array_push($array, $directory);
		array_push($array, $name);
		$path = implode('/', $array);
		$this->valid = file_exists($path);
		$info = pathinfo($path);
		//var_dump($info);
		$this->name = $name;
		$this->mime = mime_content_type($path);
	}

	public function getValid() : bool
	{ return $this->valid; }

	public function getMime()
	{
		return $this->mime;
	}

	public function getName()
	{
		return $this->name;
	}

	static public function add($extension, $group)
	{
		self::$array = self::val();
		self::$array[$extension] = $group;
		//add('jpg', 'image');
	}

	static public function val()
	{
		return is_null(self::$array) ? [] : self::$array;
	}


}

?>