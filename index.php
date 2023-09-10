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
	//$_SESSION['@']->switch_separate();
	$sep = $_SESSION['@']->is_separate();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<?php
		$a = new Folder("{$user}/{$currentName}");
		$content =$a->getContent();
		$text = "Content";
		$first = true;
		$urls = [];
		foreach ($highlights as $url => $title)
		{
			if (in_array($url, $content))
			{
				$content = array_diff($content, [$url]);
				$text = "More content";
				$first = false;
				array_push($urls, $url);
				echo "<section><h2 class='plus-padding-top'>{$title}</h2>";
				echo "<main>";
				$b = new Folder($url);
				create($sep ? separateContent($b, $urls) : $b->getContent());
				echo "</main></section>";
			}
		}
		echo "<section>";
	 	echo "<h2".($first ? " class='plus-padding-top'" : "" ).">".$text."</h2>"; ?>
		<main>
		<?php
		create($sep ? separateContent($a, $urls) : $content);
		?>
	</main>
	</section>
	<nav class="bottom"><div></div><div></div><div></div></nav>
	<section id="setting" class="content">
		<div class="container">
		<div class="card">
		<div class="card-header">Featured</div>
		<div style="overflow-y: auto; height: -webkit-fill-available;">
			<div class="card-header">Featured</div>
			<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul>
		<div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul>
		<div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul>
		<div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul>
		<div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul><div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul><div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul><div class="card-header">Featured</div>
		<ul class="list-group">
		<li class="list-group-item">An item</li>
		<li class="list-group-item">A second item</li>
		<li class="list-group-item">A third item</li>
		</ul>
		</div>
		</div>
		</div>
	</section>
</body>
</html>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
	<?php echo "var stepIn = ".(isset($_POST["today"]) && strcmp($_POST["today"], "on") == 0 ? "true" : "false").";";?>
	today(stepIn);

	setActiveStyleSheet("des-2");

	var mains = document.querySelectorAll("main");
	for (var i = 0; i < mains.length; i++)
	{
	  delegate(mains[i], "click", "div.image", openClick );
	  delegate(mains[i], "click", "div.gallery", galleryClick );
	}

	

</script>