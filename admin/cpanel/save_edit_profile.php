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
$e=$_POST["email"];
$p=password_hash($_POST["password"],PASSWORD_DEFAULT);

$sql1='UPDATE user SET email="'.$e.'", password="'.$p.'" WHERE id="'.$id.'" ';

mysqli_query($con, $sql1);
echo'<div class="alert alert-success" role="alert">
  Congratulations '.$_SESSION['name'].'! Your information has been successfully Updated!
</div>';
header("Refresh:3; url=index.php");
echo'
<a href="index.php" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Go to HomePage</a>';
?>
