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

if ($_SESSION['role'] == 'user') {
$sql='UPDATE ads SET status="pending" WHERE ad_id="'.$id.'"';
}
$sql1='UPDATE ads SET name="'.$n.'", description="'.$d.'"  WHERE ad_id="'.$id.'" ';
mysqli_query($con, $sql);
mysqli_query($con, $sql1);
echo'<div class="alert alert-success" role="alert">
  Congratulations '.$_SESSION['name'].'! Your Advertisment has been successfully Updated!
</div>';
echo'
<a href="viewad.php?id='.$id.'" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Go to Advertisments</a>';
?>
