<?php

function searchSortIndex($list, $sInd, $eInd, $elem, $lFun, $eFun, $bool=false)
{
	if(count($list)==0){ return 0; }
	$pivot = floor(($sInd+$eInd)/2);
	$compair = strcmp($eFun($elem), $lFun($list[$pivot]));
	$x = new stdClass();
	$x->e = $eFun($elem);
	$x->c = $lFun($list[$pivot]);
	$x->p = $pivot;
	$x->l = [$sInd, $eInd];
	$x->cmp = $compair;
	if ($bool) {var_dump($x);}
	if($sInd == $eInd) { return $pivot; }
	if($compair < 0) { return searchSortIndex($list, $sInd, ($pivot-1 < $sInd ? $sInd : $pivot-1), $elem, $lFun, $eFun, $bool); }
	else if($compair > 0) { return searchSortIndex($list, ($pivot+1 > $eInd ? $eInd : $pivot+1), $eInd, $elem, $lFun, $eFun, $bool); }
	return $pivot;
}

?>