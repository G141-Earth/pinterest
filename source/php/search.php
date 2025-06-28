<?php
include_once 'indexMessage.php';

function searchSortIndex($list, $sInd, $eInd, $elem, $lFun, $eFun, $bool=false) : indexMessage
{
	$message = new indexMessage();
	$obj = $message->getObject();
	if(count($list)==0)
	{
		$obj->index = 0;
		$obj->compair = 0;
		$message->setObject($obj);
		$message->setError('Array was empty');
		return $message;
	}
	$pivot = floor(($sInd+$eInd)/2);
	$compair = strcmp($eFun($elem), $lFun($list[$pivot]));
	$x = new stdClass();
	$x->e = $eFun($elem);
	$x->c = $lFun($list[$pivot]);
	$x->p = $pivot;
	$x->l = [$sInd, $eInd];
	$x->cmp = $compair;
	if ($bool) {var_dump($x);}
	$obj->index = $pivot;
	$obj->compair = $compair;
	$message->setObject($obj);
	if($sInd == $eInd)
	{
		if($compair != 0)
		{
			$message->setError("Elem is not in the array");
		}
		return $message;

	}
	if($compair < 0) { return searchSortIndex($list, $sInd, ($pivot-1 < $sInd ? $sInd : $pivot-1), $elem, $lFun, $eFun, $bool); }
	else if($compair > 0) { return searchSortIndex($list, ($pivot+1 > $eInd ? $eInd : $pivot+1), $eInd, $elem, $lFun, $eFun, $bool); }
	return $message;
}

?>