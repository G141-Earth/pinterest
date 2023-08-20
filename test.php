<?php
include_once 'OOP.php';
/*
if (isset($_POST["submit"]))
{
	if (isset($_POST["dir"]) && !empty(trim($_POST["dir"])) && $_POST["dir"][0] != '.')
	{
		$dir = $dir.$_POST["dir"];
		error_reporting(0);
		mkdir($dir, 0700);
		error_reporting(E_ALL);
		unset($_POST["dir"]);
	}
	unset($_POST["submit"]);
}
*/

if (!file_exists("uploads/.test"))
{
	mkdir("uploads/.test");
}

$A = new Folder("uploads/.test");
$A = $A->getFolders();

foreach ($A as $key => $value)
{
	rewrite($value, "", true);
}

function rewrite($oldDir, $newDir, $first)
{
$t = new folder($oldDir);
if ($first)
{
	$newDir = $oldDir."-copy";
	$first = false;
}
else
{
	$next = explode('/', $oldDir);
	$next = $next[count($next)-1];
	$newDir = "{$newDir}/{$next}";
}
mkdir($newDir, 0700);
var_dump($newDir);
$f = $t->getFiles();
foreach ($f as $key => $value)
{
	$file = explode(".", $value);
	$file = $file[count($file)-1];
	$file = ( substr(sha1(mt_rand()), 0, 32) ) .'.'. $file;
	$new = "{$newDir}/{$file}";
	$old = "{$value}";
	if (!file_exists($new))
	{
		if (rename($old, $new))
		{
		}
		else
		{
		}
	}
	var_dump($new);
}
$f = $t->getFolders();
foreach ($f as $key => $value)
{
	rewrite($value, $newDir, false);
}

}



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>