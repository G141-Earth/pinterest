<?php
include_once 'quiksort.php';
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

	static public function add($old, $new)
	{
		self::$array = self::val();
		$item = new stdClass();
		$item->new = $new;
		$item->old = $old;
		if(count(self::$array) == 0) { array_push(self::$array, $item); return;}
		$fun = function($i) { return $i->old; };
		$ind = searchSortIndex(self::$array, 0, count(self::$array)-1, $item, $fun, $fun);
		var_dump($item);
		echo "<br>";
		var_dump($ind);
		echo "<br>";
		var_dump(self::$array);
		echo "<hr>";
		echo "<hr>";
		if(strcmp(self::$array[$ind]->old, $old)==0) { echo "**"; return; }
		//Add new element to a sorted array
		//New mime class???
	}

	static public function sort($top)
	{
		if(!is_array($array))
			return;
		$i = 0;
		foreach ($top as $k => $v) {
			if(array_key_exists($k, self::$array))
			{

			}
		}
	}

	static public function val()
	{
		return is_null(self::$array) ? [] : self::$array;
	}


}

?>