<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style_login.css">

</head>
<body>
<div class="login-style">
<form class="form-login" method="post" action="login.php" novalidate="">
<?php include('error.php');?>
<img src="img/logo.jpg"class="mx-auto d-block img-fluid">
		<h2 class="form-login-heading text-center">Login</h2>
		 <input type="text" class="form-control" name="username" placeholder="Username"
		 required="" autofocus=""/>
		 <input type="password" class="form-control" name="password" placeholder="Password"
		 required="" autofocus=""/>
		 <label class="checkbox">
			 <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe">
			 Remember me
		 </label>
		 <button class="btn btn-primary btn-block" type="submit" name="login_user">login</button>
	 </form>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
