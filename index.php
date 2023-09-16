<?php
	include_once('function.php');
	include_once('OOP.php');
	session_start();
	$old = true;
	if ((!isset($_SESSION["@"])))
		header("Location: user.php");

	if (isset($_POST["refresh"]))
		logIn($_SESSION['@']->getUser());
	///////////
	if (isset($_POST['dir']) and $_SESSION['@']->setCurrent($_POST['dir']))
	{
		unset($_POST['dir']);
	}
	$currentName = $_SESSION['@']->getCurrent();
	$user = $_SESSION['@']->getUser();
	$selection = $_SESSION['@']->getLib();
	$highlights = $_SESSION['@']->getHighlight();
	$sep = $_SESSION['@']->is_separate();
	if ($sep)
	{
		$_SESSION['@']->switch_separate();
	}
	$sep = $_SESSION['@']->is_separate();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="bootstrap.css" title="">
<link rel="stylesheet" type="text/css" href="style.css" title="default">
<link rel="stylesheet" type="text/css" href="design-2.css" title="des-2" disabled>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">	
<title></title>
</head>
<body>
	<header>
		<h1><?php echo $currentName; ?></h1>
	</header>
	<nav class="folders">
	<?php
		/*
		$x = [];
		PATTERNS
		'/(^col-)/i'
		'/(^book$)/i'
		*/
		echo "<form method='POST'>";
		echo "<select name='dir'>";
		foreach ($selection as $key => $value)
		{

			//if (preg_match('/(^-)/i', $f)) { array_push($x, $f); }
			echo "<option value='".$value."'".(strcmp($currentName, $value) == 0 ? " selected" : "").">".$value."</option>";
		}
		echo "</select>";
		echo "<input type='checkbox' name='today'>";
		echo "<input type='submit' value='View'>";
		echo "<input type='submit' value='refresh' name='refresh'>";
		echo "</form>";
		echo "<a href='2.php'>Uploading file</a>";
		echo "<a href='user.php'>User</a>";
		//var_dump($x);
	?>
	</nav>
	<main>
	<div class="container-fluid">
	<div class="row">
	<div class="col-md-12">
	<?php
		$a = new Folder("{$user}/{$currentName}");
		$content =$a->getContent();
		$text = "Content";
		$urls = [];
		foreach ($highlights as $url => $title)
		{
			if (in_array($url, $content))
			{
				$folder = explode('/', $url);
				$folder = $folder[count($folder)-1];
				$content = array_diff($content, [$url]);
				$text = "More content";
				array_push($urls, $url);
				echo "<h2 class='plus-padding-top' id='{$folder}'>{$title}</h2>";
				echo "<section>";
				$b = new Folder($url);
				create($sep ? separateContent($b, $urls) : $b->getContent());
				echo "</section>";
			}
		}

		/// last section
		echo "<h2>{$text}</h2>";
		echo "<section>";
		create($sep ? separateContent($a, $urls) : $content);
		echo "</section>";
	?>
	</div>
	</div>
	</div>
	</main>
	<nav class="bottom"><div></div><div></div><div></div></nav>
</body>
</html>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
	<?php echo "var stepIn = ".(isset($_POST["today"]) && strcmp($_POST["today"], "on") == 0 ? "true" : "false").";";?>
	today(stepIn);

	setActiveStyleSheet("default");

	var mains = document.querySelectorAll("main");
	for (var i = 0; i < mains.length; i++)
	{
	  delegate(mains[i], "click", "div.image", openClick );
	  delegate(mains[i], "click", "div.gallery", galleryClick );
	}

	

</script>