<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');
}

//delete an ad
if (isset($_GET['id'])) {
   $userID=$_SESSION['role'];
   $id =(int)$_GET['id'];
   if($userID='admin')
   {
     if ($id != '') {
      $sqld='DELETE FROM ads WHERE id="'.$id.'"';
      $resR= mysqli_query($con, $sqld);
      header('Location:ads.php');
   }
 }
   else {
     if ($id != '') {
      $sqld='DELETE FROM ads WHERE id="'.$id.'" AND user_id="'.$userID.'" ';
      $resR= mysqli_query($con, $sqld);
      header('Location:ads.php');
   }
  }
}


?>
