<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<form method="post" action="register.php"
								oninput='password_2.setCustomValidity(password_2.value != password_1.value ? "Passwords do not match." : "")'>
								<?php include('error.php') ?>
								<div class="form-group">
									<label for="username">Username</label>
								<input name="username" type="username" id="inputusername" class="form-control" placeholder="username" value="<?php echo $username; ?>"  required autofocus>
									<div class="invalid-feedback">
										Username is required
									</div>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="inputemail" type="email" class="form-control" name="email" placeholder="E-Mail Address" value="<?php echo $email; ?>" required>
									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password_1"  required data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
									<div class="form-group">
										<label for="password">Confirm Password</label>
										<input id="password" type="password" class="form-control" name="password_2"  required data-eye>
										<div class="invalid-feedback">
											Password is required
										</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" name="reg_user">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="login.php">Login</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2019 &mdash; Cargo
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/my-login.js"></script>
</body>
</html>
