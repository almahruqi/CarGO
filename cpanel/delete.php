<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
header('Location: warning.php');
}
else{
  header('Location: warning.php');
}

//delete a user
if (isset($_GET['id'])) {
   $id =(int)$_GET['id'];
   if ($_SESSION['role'] == 'user') {
     header('Location:warning.php');
   }
   else{
   if ($id != '') {
    $sqlR = 'SELECT * FROM user WHERE id ='.$id.'';
    $resR= mysqli_query($con, $sqlR);
    $rowR= mysqli_fetch_assoc($resR);
        if ($rowR[role]=='user') {
        $sqlR='DELETE FROM user WHERE id="'.$id.'"';
        mysqli_query($con, $sqlR);
        header('Location:users.php');
      }
       else {
         echo '
         <div class="alert_loging">
           <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <strong>Error!</strong> You CANNOT delete an Admin!
           </div>
         ';
         header('Location:users.php');
       }


  }
}
}
?>
