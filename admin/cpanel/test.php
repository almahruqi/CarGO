<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location:warning.php');
}
if (isset($_GET['id'])) {
   $id =(int)$_GET['id'];
   $sqlphoto = 'SELECT * FROM upload_img WHERE ad_id="'.$id.'"';
   $resPHOTO= mysqli_query($con, $sqlphoto);

   if (mysqli_num_rows($resPHOTO) > 0)
   {
     while ($row2=mysqli_fetch_array($resPHOTO))
     {
       $path = $row2['img_path'];
       if (!unlink($path))
         {
         echo ("Error deleting $file");
         }
       else
         {
         echo ("Deleted $file");
         }

   }


 }
}

?>
