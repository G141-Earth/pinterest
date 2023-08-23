<?php
	include_once('function.php');
	include_once('OOP.php');
	session_start();
	//unset($_SESSION["@"]);
	$old = true;
	if ((!isset($_SESSION["@"])))
	{
		logIn("uploads");
		$old = false;
	}
	if (isset($_POST["refresh"]) && $old)
	{
		logIn("uploads");
		unset($_POST['refresh']);
	}
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
	<?php
		/*
		$root = "uploads/";
		$dir = isset($_GET["dir"]) ? $root.$_GET["dir"]."/" : $root;
		$isset = isset($_SESSION["cur"]);
		$dir = $root.($isset ? $_SESSION["cur"]."/" : "");
		$content = scandir($dir);
		$content = array_diff($content,[".", ".."]);
		$content = array_map(function ($str) use ($dir) { return $dir.$str; }, $content);
		
		$segs = [];
		if (in_array($dir."segments.json", $content))
		{
			$content = array_diff($content, [$dir."segments.json"]);
			$segs = json_decode(file_get_contents($dir."segments.json"), true);
		}
		*/
	?>
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
		/*
		if ()
		{
			$f = null;
			for ($i=2; $i < count($content) && is_null($f); $i++) { 
				if(strcmp($content[$i], $dir.".fav") == 0)
				{
					$dirF = $dir.".fav"."/";
					$f = scandir($content[$i]);
					$f = array_diff($f,[".", ".."]);
					$f = array_map(function ($str) use ($dirF) { return $dirF.$str; }, $f);
					unset($content[$i]);
				}
			}
			create($f);
			echo "</main>";
			
		}
		*/
		echo "<section>";
	 	echo "<h2".($first ? " class='plus-padding-top'" : "" ).">".$text."</h2>"; ?>
		<main>
		<?php
		create($sep ? separateContent($a, $urls) : $content);
		
		/*
		foreach ($images as $key => $value) {
			$size = getimagesize($value);
			$Y = ceil(230 / ($size[0] / $size[1]) / 10);
			print("<div class='image' style='grid-row-end: span ".$Y."; background-image: url(".$value.")' data-grid='".$Y."'></div>");
		}
		for ($i=2; $i < count($folders) && $allow ; $i++) {y
			$gIndex = -1;
			$gSize = null;
			$print = "";
			$k = $folders[array_keys($folders)[$i]];
			$f = scandir($k);
			$k = $k.'/';
			$img = array_filter(array_map(function ($str) use ($k) { return $k.$str; }, $f), "is_file");
			foreach ($img as $key => $value)
			{
				$gIndex++;
				$size = getimagesize($value);
				$Y = ceil(230 / ($size[0] / $size[1]) / 10);
				
				$print = $print . "<div class='".($gIndex > 0 ? "hide" : "")."' style='grid-row-end: span ".$Y."; background-image: url(".$value.")'></div>";
				if ($gIndex == 0) { $gSize = $Y; }
			}
			if($gIndex >= 0)
			{
				print("<div data-index='1' data-coll='".($gIndex+1)."' class='gallery' style='grid-row-end: span ".$gSize.";' >".$print."</div>");
			}
		}
		*/
		?>
	</main>
	</section>
	<nav class="bottom"><div></div><div></div><div></div></nav>
</body>
</html>
<script type="text/javascript">
	<?php echo "stepIn = ".(isset($_POST["today"]) && strcmp($_POST["today"], "on") == 0 ? "true" : "false").";";?>
	let x = document.querySelectorAll('[data-today="true"]');
	if(stepIn && x.length > 0)
	{
	let s = document.createElement('section');
	s.innerHTML = "<i><h2 class='plus-padding-top'>Today</h2></i><main><main>";
	o = document.querySelector("section");
	document.body.insertBefore(s,o);
	o = document.querySelector("main");
	for (var i = 0; i < x.length; i++)
	{
		if(x[i].className != "image" && x[i].parentElement.className == "gallery")
		{
			o.appendChild(x[i].parentElement);
		}
		else
		{
			o.appendChild(x[i]);
		}
	}
	}

	function setActiveStyleSheet(title) {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}

</script>
<script type="text/javascript" src="script.js"></script>