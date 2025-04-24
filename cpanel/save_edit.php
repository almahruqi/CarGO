<?php
include '../include/connect.php';
if ($_SESSION['id'] == '' ) {
  header('Location: warning.php');
}
$id = intval($_POST["id"]);
if ($id == '0')
{
  header('Location: ads.php');
}
?>

<?php
include 'header.php';
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Advertisments</li>
</ol>

<!-- Page Content -->
<h1>Successful Edit</h1>
<hr>


<?php
#data preparation for the query
$n=$_POST["name"];
$d=$_POST["description"];
$p=$_POST["price"];
$cmake=$_POST["car_make"];
$cmodle=$_POST["car_model"];
$cmil=$_POST["car_mileage"];
$c=$_POST["city"];
$state=$_POST["state"];

if ($_SESSION['role'] == 'user') {
$sql='UPDATE ads SET status="pending" WHERE ad_id="'.$id.'"';
}
$sql1='UPDATE ads SET name="'.$n.'", description="'.$d.'",price="'.$p.'"   WHERE ad_id="'.$id.'" ';
$sql2='UPDATE cars SET car_make="'.$cmake.'", car_model="'.$cmodle.'",car_mileage="'.$cmil.'"   WHERE ad_id="'.$id.'" ';
$sql3='UPDATE address SET city="'.$c.'", state="'.$state.'"   WHERE ad_id="'.$id.'" ';

mysqli_query($con, $sql);
mysqli_query($con, $sql1);
mysqli_query($con, $sql2);
mysqli_query($con, $sql3);
echo'<div class="alert alert-success" role="alert">
  Congratulations '.$_SESSION['name'].'! Your Advertisment has been successfully Updated!
</div>';
echo'
<a href="viewad.php?id='.$id.'" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Go to Advertisments</a>';
?>
