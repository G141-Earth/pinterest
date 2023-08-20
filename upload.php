<?php
var_dump($_POST);
if (isset($_POST["file"]))
{
	$handle = fopen($_FILES["UploadFileName"]["tmp_name"], 'r');
	$size = getimagesize($_POST["file"]);
	var_dump($size);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST">
		<input type="file" name="file">
		<input type="submit" value="Send">
	</form>
</body>
</html>