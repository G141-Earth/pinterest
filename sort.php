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
		
	?>
	<header>
		<h1><?php echo $currentName; ?></h1>
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
		$a = new Folder("{$user}/.sort");
		$content =$a->getContent();
	 	echo "<h2".($first ? " class='plus-padding-top'" : "" ).">".$text."</h2>"; ?>
		<main>
		<?php
		create(separateContent($a, []));
		?>
	</main>
	<nav class="bottom"><div></div><div></div><div></div></nav>
</body>
</html>
<script type="text/javascript" src="script.js"></script>