<?php
ob_start();
include('include/connect.php');

if(isset($_POST['submit']))
{
  $email = $_POST['email'];
  $password = $_POST['password'];
if ($email !='' && $password !='')
{
  $sql = "SELECT * FROM user WHERE email='$email'";
  $res= mysqli_query($con, $sql);
      if (mysqli_num_rows($res) > 0)
      {
         $details = mysqli_fetch_assoc($res);
        if (password_verify($password, $details['password'])) {
          $_SESSION['id'] = $details['id'];
          $_SESSION['name'] = $details['name'];
          $_SESSION['surename'] = $details['surename'];
          $_SESSION['email'] = $details['email'];
          $_SESSION['role'] = $details['role'];
          header('Location: cpanel/index.php');
          } else {
            session_destroy();
            echo '
            <div class="alert_loging">
              <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Error!</strong> Your password you entered was incorrect!
              </div>
            ';
          }
        }
        else {
          echo '
          <div class="alert_loging">
            <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> The E-mail address or password you entered was incorrect!
            </div>
          ';

        }
      }
      else {
  session_destroy();
  echo "Please fill in all fields";}

    }

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CarGo - Login</title>

  <!-- Custom fonts for this template-->
  <link href="assets/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post" role="form">
          <fieldset>
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="E-mail address" required="required">
            </div>
          <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
          <button type="submit" class="btn btn-primary btn-success btn-block" name="submit">Login</button><br>
          <a class="d-block small" href="register.php">Register new account?</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </fieldset>
        </form>
        </div>
      </div>
    </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/js/jquery.easing.min.js"></script>

</body>

</html>
