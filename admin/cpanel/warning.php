<?php
$ip = "";

if (!empty($_SERVER["HTTP_CLIENT_IP"]))
{
    // Check for IP address from shared Internet
    $ip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
    // Check for the proxy user
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
    $ip = $_SERVER["REMOTE_ADDR"];
}
session_start() ;
session_destroy() ;
header( "refresh:3;url=../index.php" );

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CarGo - 404 Page Not Found</title>

  <!-- Custom fonts for this template-->
  <link href="../assets/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="../assets/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="alert alert-danger text-center font-weight-bold" role="alert">
  <h4 class="alert-heading">404!</h4>
  <p>YOU ENTER WRONG PAGE</p>
  <p>WE WILL KEEP YOUR IP ADDRESS FOR OUR RECORDS</p>
  <hr>
  <p class="mb-0">YOUR IP ADDRESS IS :<?php echo $ip; ?></p>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/js/jquery.easing.min.js"></script>

</body>

</html>
