<?php
session_start();
include('include/connect.php');

  if (isset($_GET['key']) && isset($_GET['email'])
  && isset($_GET['action']) && ($_GET['action']=='reset')
  && !isset($_POST['action']))
  {
  $key = $_GET['key'];
  $email = $_GET['email'];
  $curDate = date('Y-m-d H:i:s');
  $sql = "SELECT * FROM password_reset_temp WHERE token='$key' AND email='$email'";
  $res= mysqli_query($con, $sql);
  $row= mysqli_num_rows($res);
  if ($row=="")
  {
  $error .= "<div class='alert alert-danger' role='alert'> <h2>Invalid Link</h2>
  <p>The link is invalid/expired. Either you did not copy the correct link from the email,
  or you have already used the key in which case it is deactivated.</p>
  <p><a href='forgot-password.php'>Click here</a> to reset password.</p>
  </div>";
    }
      else
      {
        $row1 =mysqli_fetch_assoc($res);
      	$expDate = $row1['expDate'];
      	if ($expDate >= $curDate)
        {
      	?>
        <br />
        <div class="container">
          <div class="card card-register mx-auto mt-5">
          <fieldset class="form-group"><h4>Enter New Password:</h4>
    	<form method="post" action="" name="update">
    	<input type="hidden" name="action" value="update" />
      <td>  <input type="password" name="password" class="form-control" placeholder="Password" required="required" id="Password"
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
      </td>
      </fieldset>
    	<input type="hidden" name="email" value="<?php echo $email;?>"/>
    	<input class="btn btn-primary btn-success btn-block" type="submit" id="reset" value="Reset Password" />
    </form>
    </div>
  </div>

        <?php
      }

      else{

        $error .= "<div class='alert alert-danger' role='alert'>
        <h2>Link Expired</h2>
        <p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>
        </div>";
        				}

         	 	}
            if ($error!="")
                {
                  echo "<div class='alert alert-danger' role='alert'>".$error."<a href='javascript:history.go(-1)' class='alert-link'>Go Back</a>
                  </div>";
                }
              }


      if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
      $p=password_hash($_POST["password"],PASSWORD_DEFAULT);
      $email = $_POST["email"];
      $curDate = date("Y-m-d H:i:s");
      $sql11='UPDATE user SET password="'.$p.'" WHERE email="'.$email.'" ';
      mysqli_query($con, $sql11);
      $sql12='DELETE FROM password_reset_temp WHERE email="'.$email.'" ';
      mysqli_query($con,$sql12);
      echo'<div class="alert alert-success" role="alert">
        Congratulations ! Your information has been successfully Updated!
      </div>';
      header("Refresh:3; url=login.php");
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


  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/js/jquery.easing.min.js"></script>

</body>

</html>
