<?php
	include_once('function.php');
	include_once('OOP.php');
	session_start();
	if (isset($_POST["exit"]))
	{
		unset($_POST["exit"]);
		if (isset($_SESSION["@"]))
			unset($_SESSION["@"]);
	}
	$logIn = isset($_SESSION["@"]);
	$title = $logIn ? $_SESSION['@']->getUser() : "Log in";
	///////////
	$users = new Folder(".");
	$users = $users->getFolders(true);
	$users = array_map(function($value) { return $value[count($value)-1]; }, $users);
	if (isset($_POST["user"]) && in_array($_POST["user"], $users))
	{
		logIn($_POST["user"]);
		unset($_POST["user"]);
		$logIn = $_SESSION['@']->is_success();
		if ($logIn)
			header("Location: index.php");
	}

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
		<h1><?php echo $title; ?></h1>
	</header>
	<nav class="folders">
	<?php
		if(!$logIn)
		{
			echo "<form method='POST'>";
			echo "<select name='user'>";
			foreach ($users as $key => $value)
			{
				echo "<option value='".$value."'".">".$value."</option>";
			}
			echo "</select>";
			echo "<input type='submit' value='Log in'>";
			echo "</form>";
		}
		else
		{
			echo "<form method='POST'>";
			echo "<input type='submit' name='exit' value='Log out'>";
			echo "</form>";
		}
	?>
	</nav>
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

	setActiveStyleSheet("default");

	var mains = document.querySelectorAll("main");
	for (var i = 0; i < mains.length; i++)
	{
	  delegate(mains[i], "click", "div.image", openClick );
	  delegate(mains[i], "click", "div.gallery", galleryClick );
	}

	

</script>