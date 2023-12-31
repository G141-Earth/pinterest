<?php
include_once 'OOP.php';
	function logIn($account)
	{
		$a = new Account($account);
		if ($a->is_success())
		{
			$curr = $a->getLib();
			$curr = $curr[rand(0,(count($curr)-1))];
			$a->setCurrent($curr);
			$_SESSION["@"] = $a;
		}
	}

	function folderCheck()
	{
		if (!(isset($_SESSION["dir"])))
		{
			$dir = [];
		}
	}
	function sortByTime($list)
	{
		$key = array_keys($list);
		for ($i = 1; $i < count($list); $i++)
		{
			$temp = $list[$key[$i]];
			$j = $i - 1;
			while ($j >= 0 && filemtime($temp) > filemtime($list[$key[$j]]))
			{
				$list[$key[$j+1]] = $list[$key[$j]];
				$list[$key[$j]] = $temp;
				$j -= 1;
			}
		}
		return $list;
	}

	function separateContent($folder, $highlight)
	{
		$f = $folder->getFiles();
		foreach (array_diff($folder->getFolders(), $highlight) as $key => $value)
		{
			$sub = new Folder($value);
			$f = array_merge($f, $sub->getFiles());
		}
		sort($f);
		return $f;
	}

	function create($array, $before=86400)
	{
		$tomorrow = time() - $before;
		foreach ($array as $key => $value)
		{
			if (is_file($value)) 
			{
				$array[$key] = [$value];
			}
			else
			{
				$f = new Folder($value);
				$array[$key] = $f->getFiles();
			}
			if (count($array[$key]) == 1)
			{
				$index = array_keys($array[$key])[0];
				$elem = $array[$key][$index];
				$size = getimagesize($elem);
				$time = filemtime($elem) > $tomorrow ? "true" : "false";
				$Y = ceil(230 / ($size[0] / $size[1]) / 10);
				print("<div class='image' style='grid-row-end: span {$Y}; background-image: url({$elem})' data-grid='{$Y}' data-today='{$time}'></div>");
			}
			else if (count($array[$key]) > 1)
			{
				$elem = $array[$key];
				//var_dump($elem);
				$gIndex = -1;
				$gSize = null;
				$print = "";
				foreach ($elem as $e)
				{
					$gIndex++;
					$size = getimagesize($e);
					$Y = ceil(230 / ($size[0] / $size[1]) / 10);
					
					$stat = $gIndex > 0 ? "hide" : "";
					$time = filemtime($e) > $tomorrow ? "true" : "false";

					$print = $print . "<div class='{$stat}' data-today='{$time}' style='grid-row-end: span {$Y}; background-image: url({$e})'></div>";
					if ($gIndex == 0) { $gSize = $Y; }
				}
				if($gIndex >= 0)
				{
					print("<div data-index='1' data-coll='".($gIndex+1)."' class='gallery' style='grid-row-end: span {$gSize};' >{$print}</div>");
				}
			}
		}
	}

	function filter($name)
	{
		return $name[0] != '.';
	}

	function onlyImage($f)
	{
		if (is_file($f))
		{
			$i = ["webp", "jpg", "jpeg", "png", "jfif", "avif"];
			$s = explode('.', $f);
			$e = $s[count($s)-1];
			return in_array($e, $i);
		}
		return false;
	}
?>

<?php
	/*
	$a = [];
	$a[".fav"] = "Favorite";
	$a[".run"] = "Runway";
	var_dump(json_encode($a));
	*/
?>