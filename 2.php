<?php
include_once('OOP.php');
session_start();
$target_dir = '';
$target_file = null;
$folder = [];
$now = time();
if (isset($_SESSION["@"]) && !is_null($_SESSION["@"]->getCurrent()))
{
  $target_dir = $_SESSION["@"]->getUser();
  $target_dir = $target_dir."/".$_SESSION["@"]->getCurrent();
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
}
if (isset($_POST["submit"]))
{
  $ind = count($_FILES["fileToUpload"]["name"]);
  for ($i=0; $i < $ind; $i++)
  {
    uploadCheck($i, $now, null);
    echo "<hr>";
  }
}

function uploadCheck($index, $now, $target_file)
{
  var_dump($_POST);
  if (isset($_POST["target"]))
  {
    $target_dir = $_POST["target"];
  }

  if (isset($_POST["submit"]))
  {
    $target_file = $target_dir . ( substr(sha1(mt_rand()), 0, 32) ) .'.'. explode('/', $_FILES["fileToUpload"]["type"][$index])[1];
    var_dump($target_file);
  }
  $uploadOk = true;

  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"]))
  {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$index]);
    if($check !== false)
    {
      echo "File is an image - " . $check["mime"] . ".";
    }
    else
    {
      echo "File is not an image.";
      $uploadOk = false;
    }
  }

  // Check if file already exists
  if (isset($_POST["submit"]) && file_exists($target_file))
  {
    echo "Sorry, file already exists.";
    $uploadOk = false;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" && $imageFileType != "jfif" && isset($_POST["submit"]) )
  {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = false;
  }
  // Check if $uploadOk is set to 0 by an error
  if (!$uploadOk && isset($_POST["submit"]))
  {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  }
  else
  {
    if (isset($_POST['timestap']) && is_numeric($_POST['timestap']) && $_POST['timestap']+30 >= $now)
    {
      if (isset($_POST["submit"]) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$index], $target_file))
      {
        echo "The file ". htmlspecialchars( basename( $target_file)). " has been uploaded.";
      }
      elseif(isset($_POST["submit"]))
      {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }
  return $uploadOk;
}
?>

<!DOCTYPE html>
<html>
<body>
<form method="post" enctype="multipart/form-data">
  <select name="target">
    <?php
    foreach ($folder as $key => $value)
    {
      $value = $value.'/';

      echo "<option value='{$value}'>{$value}</option>";
    }
    ?>
  </select>
  Select image to upload:
  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
  <input type="submit" value="Upload Image" name="submit">
  <?php echo "<input type='hidden' name='timestap' value={$now}>"; ?>
</form>
</body>
</html>