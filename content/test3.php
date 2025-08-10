<?php
include_once '../source/php/leaf-2.php';
include_once '../source/php/leafMessage.php';
include_once '../source/php/boolMessage.php';
include_once '../source/php/factory.php';

$messageMain = new boolMessage();
$a = Factory::create('', '../libary/test.tx',2);
$a = $a->getObject();
$c;
$a = Factory::evolve($a);
$b = $messageMain->check($a);
var_dump($a);
echo "<hr>";
var_dump($messageMain)
//$b = Factory::evolve();


?>