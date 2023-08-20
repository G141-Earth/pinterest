<?php
include_once('function.php');
include_once('x.php');

	if (!file_exists("uploads/.sort"))
	{
		mkdir("uploads/.sort");
	}

	if ((!isset($_SESSION["@"])))
	{
		logIn("uploads");
	}

	$_POST["dir"] = ".sort";
	if (isset($_POST['dir']) and $_SESSION['@']->setCurrent($_POST['dir']))
	{
		unset($_POST['dir']);
	}
	$currentName = $_SESSION['@']->getCurrent();
	$user = $_SESSION['@']->getUser();
	$selection = $_SESSION['@']->getLib();
	$highlights = $_SESSION['@']->getHighlight();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$root = $_SESSION["user"]."/";
		$dir = isset($_GET["dir"]) ? $root.$_GET["dir"]."/" : $root;
		$dir = $root.$_SESSION["cur"]."/";
		$content = scandir($dir);
		//$content = array_diff($content,[".", ".."]);
		$content = array_map(function ($str) use ($dir) { return $dir.$str; }, $content);
		$content = array_filter($content,"onlyImage");
		$segs = [];
		if (in_array($dir."segments.json", $content))
		{
			$content = array_diff($content, [$dir."segments.json"]);
			$segs = json_decode(file_get_contents($dir."segments.json"), true);
		}
		
	?>
	<header>
		<h1><?php echo $_SESSION["cur"]; ?></h1>
	</header>
	<nav class="folders">
	<?php
		//$folder = array_map(function ($str) use ($root) { return $root.$str; }, $folder);
		echo "<form method='POST'>";
		echo "<select name='dir'>";
		foreach ($selection as $key => $value)
		{

			//if (preg_match('/(^-)/i', $f)) { array_push($x, $f); }
			echo "<option value='".$value."'".(strcmp($currentName, $value) == 0 ? " selected" : "").">".$value."</option>";
		}
		echo "</select>";
		echo "<input type='submit' value='View'>";
		echo "</form>";
	?>
	</nav>
	<?php
		$text = "Content";
		$first = true;
		foreach ($segs as $sub => $title)
		{
			$subdir = $dir.$sub;
			if (in_array($subdir, $content))
			{
				$text = "More content";
				$first = false;
				echo "<h2 class='plus-padding-top'>".$title."</h2>";
				echo "<main>";
				$f = null;
				foreach ($content as $key => $value)
				{
					if(strcmp($value, $subdir) == 0)
					{
						$dirF = $subdir."/";
						$f = scandir($value);
						$f = array_diff($f,[".", ".."]);
						$f = array_map(function ($str) use ($dirF) { return $dirF.$str; }, $f);
						unset($content[$key]);
					}
				}
				create($f);
				echo "</main>";
			}
		}
	 	echo "<h2".($first ? " class='plus-padding-top'" : "" ).">".$text."</h2>"; ?>
		<main>
		<?php
		create($content);
		?>
	</main>
	<nav class="bottom"><div></div><div></div><div></div></nav>
</body>
</html>
<script type="text/javascript" src="script.js"></script>