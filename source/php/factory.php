  <?php

include_once 'leaf-2.php';
include_once 'file.php';
include_once 'folder.php';
include_once 'leafMessage.php';

class factory
{
	
	function __construct()
	{
		# code...
	}

	public static function create(string $class, string $path, int $index) : leafMessage
	{
		$message = new leafMessage();
		if(strcmp($class, 'file')==0)
		{
			$message->setObject(new File($path, $index));
			return $message;
		}
		else if(strcmp($class, 'folder')==0)
		{
			$message->setObject(new Folder($path, $index));
			return $message;
		}
		$message->setObject(new Leaf2($path, $index));
		return $message;
	}

	public static function evolve(Leaf2 $obj, bool $folder=false) : leafMessage
	{
		$messageMain = new leafMessage();
		$message = $obj->getValid();
		$error = !$messageMain->check($message);
		if($error){ return $messageMain; }
		$message = $obj->getMime();
		$error = !$messageMain->check($message);
		if($error){ return $messageMain; }
		$mime = $message->getObject();
		$message = $obj->getAbsolutePath();
		$error = !$messageMain->check($message);
		if($error){ return $messageMain; }
		$path = $message->getObject();
		$message = $obj->getRootIndex();
		$error = !$messageMain->check($message);
		if($error){ return $messageMain; }
		$index = $message->getObject();
		if(strcmp('directory', $mime) == 0 && $folder)
		{
			$messageMain->setObject(new Folder($path, $index));
		}
		else if(strcmp('directory', $mime) != 0)
		{
			$messageMain->setObject(new File($path, $index));
		}
		return $messageMain;
	}
}

?>