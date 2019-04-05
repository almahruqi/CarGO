<?php
include('include/connect.php');

if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $surename = $_POST['surename'];
  $email = $_POST['email'];
  $hashed_password = password_hash($_POST["password"],PASSWORD_DEFAULT);
if ($name !='' && $surename !='' && $email !='' && $hashed_password !='')
{
  $sql = "SELECT * FROM user WHERE email='$email'";
  $res= mysqli_query($con, $sql);
  if (mysqli_num_rows($res) > 0)
  {
    echo'
    <div class="alert_loging">
      <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <strong>Error!</strong> The Email Address Already exist!
          <a href="Login.php">Click here to Login</a>
      </div>
    ';
  }
  else{
    echo 'k';
  // $query = "INSERT INTO user (name, surename, email, password)
  //       VALUES('$name', '$surename', '$email', '$hashed_password')";
  // mysqli_query($con, $query);
  // header('Location: login.php');
}
} else {
  echo "Please fill in all fields";
}

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

  <title>CarGo - Register</title>

  <!-- Custom fonts for this template-->
  <link href="assets/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">
  <!-- password checker -->


</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form method="post" role="form">
          <fieldset>
          <div class="form-group">
                  <input type="text"  name="name" class="form-control"  placeholder="Name" required="required" autofocus="autofocus">
                </div>
              <div class="form-group">
                  <input type="text" name="surename" class="form-control" placeholder="Surename" required="required" autofocus="autofocus">
                </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="E-mail address" required="required">
            </div>
          <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password" required="required" id="psw"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <h4><b>Password must contain the following:</b></h4>
                  <p><b>lowercase</b> letter</p>
                  <p>A <b>capital (uppercase)</b> letter</p>
                  <p>A <b>number</b></p>
                  <p>Minimum <b>8 characters</b></p>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
                </div>
                </div>

          <button type="submit" class="btn btn-primary btn-success btn-block" name="submit">Register</button><br>
          <a class="d-block small mt-3" href="login.php">Login Page</a>
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
