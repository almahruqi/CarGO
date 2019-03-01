<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location:warning.php');
}

?>

<?php
if ($_SESSION['role'] == 'user') {
  header('Location:warning.php');
}
elseif ($_SESSION['role'] == 'admin'){
  if (isset($_GET['id'])) {
     $userID=$_SESSION['role'];
     $id =(int)$_GET['id'];
     if($userID='admin')
     {
       if ($id != '') {
        $sqld='DELETE FROM ads WHERE ad_id="'.$id.'"';
        $resR= mysqli_query($con, $sqld);
        header('Location:ads.php');
     }
   }
     else {
       if ($id != '') {
        $sqld='DELETE FROM ads WHERE ad_id="'.$id.'" AND user_id="'.$userID.'" ';
        $resR= mysqli_query($con, $sqld);
        header('Location:ads.php');
     }
    }
  }
}


?>
