<?php
	include_once('function.php');
	include_once('OOP.php');
	session_start();
	//unset($_SESSION["folder"]);
	var_dump($_POST);

	if ((!isset($_SESSION["@"]))) { logIn("uploads"); }
	$cur = $_SESSION["@"]->getCurrent();
	$user = $_SESSION["@"]->getUser();
	$lib = $_SESSION["@"]->getLib();

	if (!isset($_SESSION["folder"]) || isset($_POST['reset']))
		$_SESSION["folder"]=[null, null, null];
	if (isset($_POST['reset']))
		unset($_POST['reset']);

	$F = $_SESSION["folder"];
	$s = true;
	$suc = 0;

	// Post main only send if is checked
	if (isset($_POST['main']) && isset($_POST['next-1']))
	{
		$F[0] = true;
		unset($_POST['main']);
		unset($_POST['next-1']);
	}
	elseif(isset($_POST['next-1']))
	{
		$F[0] = false;
		unset($_POST['next-1']);
	}

	////////////////////////

	if (is_bool($F[0]) && $F[0])
	{
		//suc % 2 == 1
		$suc = 1;
		if (isset($_POST['next-2']) && isset($_POST['dir']) && !empty(trim($_POST['dir'])))
		{
			//no space or any special character CHECK
			$suc += 2;
			$F[floor($suc/2)] = strtolower($_POST['dir']);
			unset($_POST['dir']);
			unset($_POST['next-2']);
		}
		if ($suc == 3 && $s)
		{
			$url = "{$user}/{$F[floor($suc/2)]}";
			if (!file_exists($url))
				mkdir($url);
			else
				$s = false;
			
			unset($_SESSION["folder"]);
			$suc = 0;
		}
	}
	elseif(is_bool($F[0]))
	{
		$suc = 2;
		if (isset($_POST['next-2']) && $_SESSION["@"]->setCurrent($_POST['dir']))
		{
			$F[$suc/2] = $_POST['dir'];
			$folder = new Folder("{$user}/{$F[$suc/2]}");
			$suc += 2;
			$highlight = $_SESSION['@']->getHighlight();
			echo "<hr>";
			/*
			var_dump(array_map(function ($url)
			{
				$segs = explode('/', $url);
				return $segs[count($segs)-1];
			}, $folder->getFolders()));
			*/
			var_dump($folder->getFolders());
			echo "<hr>";
			var_dump($highlight);
			echo "<hr>";
		}
		else
			$s = false;
	}
	
	/*
	$all = [];
	foreach ($lib as $k => $l)
	{
		$_SESSION["@"]->setCurrent($l);
		$target_dir = "{$user}/".$_SESSION["@"]->getCurrent();
		$folder = new Folder($target_dir);
		$folder = $folder->getFolders();
		$more = $_SESSION["@"]->getHighlight();
		foreach ($more as $key => $value)
		{
			$temp = new Folder($key);
			$folder = array_merge($folder, $temp->getFolders());
		}
		array_push($folder, $target_dir."/.");
		sort($folder);
		$all[$l]=$folder;
	}
	*/
	$_SESSION["@"]->setCurrent($cur);
	$_SESSION['folder'] = $F;
	var_dump($_SESSION['folder']);
	var_dump($s);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<h1>folders</h1>
	</header>
	<section>
	<form method="POST">
		<?php
		switch ($suc)
		{
			case 0:
				echo "<label>Is a main folder?</label>";
				echo "<input name='main' type='checkbox'></input>";
				echo "<input type='submit' name='next-1' value='Next' style='display: none'>";
				break;
			case 2:
				$first = true;
				echo "<select name='dir'>";
				foreach ($lib as $key => $value)
				{
					echo "<option value='".$value."'".( $first ? " selected" : "").">".$value."</option>";
					$first = false;
				}
				echo "</select>";
				echo "<input type='submit' name='next-2' value='Next'>";
				break;
			case 1:
				echo "<input type='text' name='dir' value=''>";
				echo "<input type='submit' name='next-2' value='Next'>";
				break;

			default:
				# code...
				break;
		}
		echo "<input type='submit' name='reset' value='Reset'>";
		?>
	</form>
	</section>
</body>
</html>