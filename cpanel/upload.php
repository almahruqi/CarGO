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
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Upload</title>
</head>

<body>

  <h2>Rules of uploading image</h2>

  <ul class="list-group-item">
  <li class="list-group-item list-group-item-success">Image can be Only PNG and JPEG.</li>
  <li class="list-group-item list-group-item-success">Image CANNOT exceeds 5MB!</li>
  <li class="list-group-item list-group-item-success">Image should be clear and related to the Ad</li>
</ul>
<div class="container-fluid mt-3 pt-2">
  <div class="row">
      <div class="col-md-offset-19 col-lg-11 ">
        <form action="" method="post" enctype="multipart/form-data" >
        <input type="file" name="file_img" class="custom-file-input" id="inputGroupFile02">
        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
      </div>
       <div class="input-group-append">
      <input type="submit" name="btn_upload" class="input-group-text" value="Upload">
        </form>
        </div>
      </div>
    </div>
<script>
            $('#inputGroupFile02').on('change',function(){
                //get the file name
                var fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
		
            })
        </script>
    </div>





<?php

if ($id != '') {
  if(isset($_POST['btn_upload']))
  {
  	$filetmp = $_FILES["file_img"]["tmp_name"];
  	$filename = $_FILES["file_img"]["name"];
  	$filetype = $_FILES["file_img"]["type"];
  	$filepath = "../photo/".$filename;
    $file_extension = pathinfo($_FILES["file_img"]["name"], PATHINFO_EXTENSION);
    $allowed_image_extension = array("png","jpg","jpeg");

    // Validation (https://phppot.com/php/php-image-upload-with-size-type-dimension-validation/)
    if (!file_exists($_FILES["file_img"]["tmp_name"])) {
      echo '
      <div class="alert_loging">
        <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> Choose image file to upload!
        </div>
      ';
      }
    else if(! in_array($file_extension, $allowed_image_extension))
    {
      echo '
      <div class="alert_loging">
        <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> Only PNG and JPEG images are allowed!
        </div>
      ';
    }
    else if(($_FILES["file_img"]["size"] > 5000000))
    {
      echo '
      <div class="alert_loging">
        <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> Image size exceeds 5MB!
        </div>
      ';
    }
  	else {
    move_uploaded_file($filetmp,$filepath);
  	$sql = "INSERT INTO upload_img (img_name,img_path,img_type,ad_id) VALUES ('$filename','$filepath','$filetype','$id')";
    $sql1 = 'SELECT status FROM ads WHERE ad_id ='.$id.'';
    $resR= mysqli_query($con, $sql1);
    $rowR= mysqli_fetch_assoc($resR);
    if ($rowR['status']=='approved') {
    $sqlR='UPDATE ads SET status="pending" WHERE ad_id="'.$id.'"';
    mysqli_query($con, $sqlR);
      }
  	mysqli_query($con, $sql);

    echo'<div class="alert alert-success" role="alert">
      Congratulations '.$_SESSION['name'].'! The Images has been successfully uploaded!
    </div>';
    echo'
    <a href="viewad.php?id='.$id.'" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Go to Advertisments</a>';
  }
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
