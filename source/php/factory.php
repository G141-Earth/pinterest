<?php

include_once 'leaf-2.php';
include_once 'file.php';
include_once 'folder.php';

class factory
{
	
	function __construct()
	{
		# code...
	}

	public static function create(string $class, string $path, int $index) : Leaf2
	{
		if(strcmp($class, 'file')==0)
		{
			return new File($path, $index);
		}
		else if(strcmp($class, 'folder')==0)
		{
			return new Folder($path, $index);
		}
		return new Leaf2($path, $index);
	}

	public static function evolve(Leaf2 $obj, bool $folder=false) : Leaf2
	{
		//is_success check 3 times
		$message = $obj->getMime();
		$mime = $message->getObject();
		$message = $obj->getAbsolutePath();
		$path = $message->getObject();
		$message = $obj->getRootIndex();
		$index = $message->getObject();
		if(strcmp('directory', $mime) == 0 && $folder)
		{
			return new Folder($path, $index);
		}
		else if(strcmp('directory', $mime) != 0)
		{
			return new File($path, $index);
		}
		return $obj;
	}
}

?>