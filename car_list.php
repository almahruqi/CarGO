<?php
include 'include/connect.php';//make sure you have folder include!
?>
<!DOCTYPE html>
<html lang="zxx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Car list</title>
		<link rel="icon" href="favicon.ico">
		<!-- JqueryUI -->
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="css/boostrap/bootstrap.min.css">
		<!-- Awesome font icons -->
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
		<!--magnific popup-->
		<link rel="stylesheet" type="text/css" href="css/magnific-popup/magnific-popup.css" media="screen"/>
		<!-- Owlcoursel -->
		<link rel="stylesheet" type="text/css" href="css/owl-coursel/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="css/owl-coursel/owl.theme.css">
		<!-- Main style -->
		<link  rel="stylesheet" type="text/css" href="css/style.css">
		<!-- Padding / Margin -->
		<link  rel="stylesheet" type="text/css" href="css/padd-mr.css">
		<!-- dark version-->
		<link id="vers" rel="stylesheet" type="text/css" href="css/dark-version.css">
		<!-- Boxed-->
		<link id="boxed" rel="stylesheet" type="text/css" href="css/boxed.css">
	</head>
	<body class="bg-1">
		<!-- Preloader -->
		<div class="preloader"><p></p></div>
		<div id="wrap" class="color1-inher">
			<!-- Header -->
			<header id="wrap-header"  class="color-inher">
				<div class="top-header">
					<div class="container">
						<div class="row">
							<div class="col-sm-6 col-md-6 col-lg-6 hidden-xs">
								<p class="f-14"><i class="fa fa-map-marker m-r-lg-5"></i><strong>CarGo</strong> - Long Beach / CA</p>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<ul class="pull-right">
									<li><a href="cpanel/index.php" class="icon-1"><i class="fa fa-user"></i><span>My Account</span></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="menu-bg">
					<div class="container">
						<div class="row">
							<!-- Logo -->
							<div class="col-md-3 col-lg-3">
								<a href="index.php" class="logo"><img src="images/logo.png" alt="logo"></a>
							</div>
							<div class="col-md-9 col-lg-9">
								<div class="hotline">
									<span class="m-r-lg-10">Need support? Email us:</span>
									<i class="fa fa-phone"></i>support@cargo.x10host.com
								</div>
								<div class="clearfix"></div>
								<!-- Menu -->
								<div class="main-menu">
									<div class="container1">
										<nav class="navbar navbar-default menu">
											<div class="container-fluid">
												<div class="navbar-header">
													<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
														<span class="sr-only">Toggle navigation</span>
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
													</button>
												</div>
												<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
													<ul class="nav navbar-nav">
														<li class="dropdown">
															<a href="index.php">Home</a>
														</li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Recent Car Listing</a>
															<ul class="dropdown-menu">
																<li><a href="car_list.php">Car List</a></li>
															</ul>
														</li>
														</li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LogIn/ Register </a>
															<ul class="dropdown-menu">

																<li><a href="login.php">Login </a></li>
																<li><a href="register.php">Register</a></li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</nav>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- Main content -->
			<div id="wrap-body" class="p-t-lg-30">
				<div class="container">
					<div class="wrap-body-inner">
						<!-- Breadcrumb-->
						<div class="hidden-xs">
							<div class="row">
								<div class="col-lg-6">
									<ul class="ht-breadcrumb pull-left">
									<li class="home-act"><a href="#"><i class="fa fa-home"></i>Home</a></li>
									<li class="home-act"><a href="car_list.php">Listing</a></li>
									</ul>
								</div>
								<div class="col-lg-6">
									<a href="cpanel/newad.php" class="ht-btn ht-btn-default pull-right m-t-lg-0" onclick="window.location.href='cpanel/newad.php'" type="button" value="Text" /><i class="fa fa-upload" ></i>Upload your Vehicle</a>
									<form>
									</form>
								</div>
							</div>
						</div>
						<!-- Car list -->
						<section class="block-product m-t-lg-30 m-t-xs-0">
							<div class="row">
								<div class="col-sm-5 col-md-4 col-lg-3">
										</div>
									</div>
									<div class="clearfix"></div>

									<!-- Car -->
									<div class="product product-list car">
										<div class="clearfix"></div>
										<!-- Product item -->
										<?php
										$sql = 'SELECT * FROM ads WHERE status ="approved" ORDER BY date DESC LIMIT 20';
										$res= mysqli_query($con, $sql);
										if (mysqli_num_rows($res) > 0)
										{
											while ($row =mysqli_fetch_assoc($res))
										  {
												$sql1 = "SELECT * FROM user WHERE id ='$row[user_id]'";
												$res1= mysqli_query($con, $sql1);
												$row1= mysqli_fetch_assoc($res1);
												$names=$row1['name'].' '.$row1['surename'];
										    $sql2 = "SELECT * FROM upload_img WHERE ad_id ='$row[ad_id]' LIMIT 1";
												$res2= mysqli_query($con, $sql2);
												$row2= mysqli_fetch_assoc($res2);
										    $img=$row2['img_name'];
												$sql3 = "SELECT * FROM cars WHERE ad_id ='$row[ad_id]'";
												$res3= mysqli_query($con, $sql3);
												$row3= mysqli_fetch_assoc($res3);

												echo '
												<div class="product-item hover-img">
													<div class="row">
														<div class="col-sm-12 col-md-5 col-lg-5">
															<a href="car_detail.php?id='.$row['ad_id'].'" class="product-img"><img src="photo/'.$row2['img_name'].'" alt="image"></a>
														</div>
														<div class="col-sm-12 col-md-7 col-lg-7">
															<div class="product-caption">
																<h4 class="product-name">
																	<a href="car_detail.php?id='.$row['ad_id'].'" class="f-18">'.$row['name'].'</a>
																</h4>
																<b class="product-price color-red">'.$row['price'].'</b>
																<p class="product-txt m-t-lg-10">'.$row['description'].'</p>
																<ul class="static-caption m-t-lg-20">
																	<li><i class="fa fa-clock-o"></i>'.$row3['car_model'].'</li>
																	<li><i class="fa fa-road"></i>'.$row3['car_mileage'].'</li>

																</ul>
															</div>
														</div>
													</div>
												</div>
																				';
											}
										}
										?>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
			<!-- Footer-->
			<footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © CarGo 2019</span>
          </div>
        </div>
      </footer>
		</div>
		<!-- jQuery -->
		<script src="js/jquery/jquery-2.2.4.min.js"></script>
		<!-- JqueryUI -->
		<script src="js/jquery/jquery-ui.js"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap/bootstrap.min.js"></script>
		<!--magnific popup-->
		<script src="js/magnific-popup/jquery.magnific-popup.min.js"></script>
		<!-- Jquery.counterup -->
		<script src="js/jquery.counterup/waypoints.min.js"></script>
		<script src="js/jquery.counterup/jquery.counterup.min.js"></script>
		<!-- Owl-coursel -->
		<script src="js/owl-coursel/owl.carousel.js"></script>
		<!-- Script -->
		<script src="js/script.js"></script>
	</body>
</html>
