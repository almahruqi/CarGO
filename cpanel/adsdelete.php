<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location:warning.php');
}

?>

<?php
$userID=$_SESSION['role'];
$uID=$_SESSION['id'];
$id =(int)$_GET['id'];
$sqlcheck = 'SELECT * FROM ads WHERE ad_id="'.$id.'" AND user_id="'.$uID.'" ';
$rescheck= mysqli_query($con, $sqlcheck);
if (mysqli_num_rows($rescheck) > 0 || $_SESSION['role'] =='admin')
{
  if (isset($_GET['id'])) {

     if($userID='admin')
     {
       if ($id != '') {
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
              header("Refresh:1; url=ads.php");
              }
            else
              {
              $sqld='DELETE FROM ads WHERE ad_id="'.$id.'"';
              $resR= mysqli_query($con, $sqld);
              header('Location: ads.php');}
              }
        }
        else {
          $sqld='DELETE FROM ads WHERE ad_id="'.$id.'"';
          $resR= mysqli_query($con, $sqld);
          header('Location: ads.php');
        }
      }
        }
     else {
       if ($id != '') {
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
              header("Refresh:1; url=ads.php");
              }
            else
              {
              $sqld='DELETE FROM ads WHERE ad_id="'.$id.'" AND user_id="'.$uID.'"';
              $resR= mysqli_query($con, $sqld);
              header('Location: ads.php');
            }
            }

        }
        else {
          $sqld='DELETE FROM ads WHERE ad_id="'.$id.'" AND user_id="'.$uID.'"';
          $resR= mysqli_query($con, $sqld);
          header('Location: ads.php');}
          if(!$resR)
          {
            echo ("Error");
            header("Refresh:5; url=ads.php");
          }
        }
      }
     }
   }
   else {
     header('Location:warning.php');
   }


?>
