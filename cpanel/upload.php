<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');

}

$id =(int)$_GET['id'];
$sqlR = 'SELECT user_id FROM ads WHERE ad_id="'.$id.'" ';
$res1= mysqli_query($con, $sqlR);
$row1= mysqli_fetch_assoc($res1);
$idd=$_SESSION['id'];
$tt=$row1['user_id'];
if ($idd!=$tt && $_SESSION['role'] == 'user') {
header('Location: ads.php');
}


?>
<?php
include 'header.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file_img" />
<input type="submit" name="btn_upload" value="Upload">
</form>

<?php

if ($id != '') {
  if(isset($_POST['btn_upload']))
  {
  	$filetmp = $_FILES["file_img"]["tmp_name"];
  	$filename = $_FILES["file_img"]["name"];
  	$filetype = $_FILES["file_img"]["type"];
  	$filepath = "../photo/".$filename;
    $file_extension = pathinfo($_FILES["file_img"]["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is not empty
    if (!file_exists($_FILES["file_img"]["tmp_name"])) {
      echo '
      <div class="alert_loging">
        <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> Choose image file to upload!
        </div>
      ';
      }
  	else {
    move_uploaded_file($filetmp,$filepath);
  	$sql = "INSERT INTO upload_img (img_name,img_path,img_type,ad_id) VALUES ('$filename','$filepath','$filetype','$id')";
  	mysqli_query($con, $sql);
    header('Location: ads.php');}
  }
}
else {
  header('Location: ads.php');}



?>
<?php

include 'footer.php';
 ?>
</body>
</html>
