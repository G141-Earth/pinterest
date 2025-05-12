<?php

include_once '../source/php/file.php';
include_once '../source/php/folder.php';
include_once '../source/php/path.php';
function write($value, $x=false)
{
	var_dump($value);
	$X = is_bool($x) ? $x : false;
	if ($X)
	{echo "<hr>";}
	else{ echo "<br>"; }
}
$a = new Folder('../libary/folder',2);
echo "<hr>";
//$b = new File('../../libary/856a089c5a669d8d41adbe4f571dff3b.webp',3);
$b = new File('../libary/folder/image.png',2);
//$b = new File('../../libary/collection/er',3);
write($a->getRelativePath()->getObject());
write($a->getAbsolutePath()->getObject());
write($a->getName()->getObject(), true);
write($a,true);
write($b->getRelativePath()->getObject());
write($b->getAbsolutePath()->getObject());
write($b->getName()->getObject(),true);
write($b,true);
write($a->read(),true);
?>