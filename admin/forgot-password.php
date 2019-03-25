<?php
session_start();
include('include/connect.php');
require_once 'libs/phpmailer/PHPMailerAutoload.php';

if(isset($_POST['submit'])&& (!empty($_POST["email"])))
{
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $sql = "SELECT * FROM user WHERE email='$email'";
  $res= mysqli_query($con, $sql);
  $row= mysqli_num_rows($res);

  if ($row==""){
  $error .= "<div class='alert alert-danger' role='alert'> <p>No user is registered with this email address!</p></div>";
  }
  if ($error!="")
      {
        echo "<div class='alert alert-danger' role='alert'>".$error."<a href='javascript:history.go(-1)' class='alert-link'>Go Back</a>
        </div>";
      }
      else {
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
         $expDate = date("Y-m-d H:i:s",$expFormat);
         $key = md5(2418*2+$email);
         $addKey = substr(md5(uniqid(rand(),1)),3,10);
         $key = $key . $addKey;
         // Insert Temp Table
         $query = "INSERT INTO password_reset_temp (email, token, expDate) VALUES('$email', '$key','$expDate')";
         mysqli_query($con, $query);
         //send the Email
         $m=new PHPMailer;
         $m->isSMTP();
         $m->SMTPAuth=true;
         $m->Host='smtp.gmail.com';
         $m->Username='car.go.csulb@gmail.com';//replace with your email address
         $m->Password='cargo159+159';//replace with your password
         $m->SMTPSecure='ssl';
         $m->Port=465;
         $m->isHTML();
         $m->Subject ='Password Recovery - CarGo';
         $output='<p>Dear user,</p>';
         $output.='<p>Please click on the following link to reset your password.</p>';
         $output.='<p>-------------------------------------------------------------</p>';
         $output.='<p><a href="http://localhost:8888/admin/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">http://localhost:8888/admin/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
         $output.='<p>-------------------------------------------------------------</p>';
         $output.='<p>Please be sure to copy the entire link into your browser.
         The link will expire after 1 day for security reason.</p>';
         $output.='<p>If you did not request this forgotten password email, no action
         is needed, your password will not be reset. However, you may want to log into
         your account and change your security password as someone may have guessed it.</p>';
         $output.='<p>Thanks,</p>';
         $output.='<p>CarGo Team</p>';
         $m->Body=$output;
         $m->FromName='CarGo Team';
         $m->AddAddress($email,'user');
         if ($m->send()) {
           echo "<div class='alert alert-success' role='alert'>
           <p>An email has been sent to you with instructions on how to reset your password.</p>
           <p> You will be redirected to the login page after 3 seconds!</p>
           </div>";
           header("Refresh:3; url=login.php");
         }else{
           echo "<div class='alert alert-danger' role='alert'>
           <p>An email has been sent to you with instructions on how to reset your password.</p>
           </div><br /><br /><br />";
         }

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

  <title>CarGo - Forget Password</title>

  <!-- Custom fonts for this template-->
  <link href="assets/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header text-center">Forget Password</div>
      <div class="card-body">
        <form method="post" role="form" name="rest" action="">
          <fieldset>
            <div class="form-group">
              <p class="font-weight-bold">Enter Your Email Address</p>
              <input type="email" name="email" class="form-control" placeholder="E-mail address" required="required">
            </div>
          <button type="submit" class="btn btn-primary btn-success btn-block" name="submit">Rest Password</button><br>
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
