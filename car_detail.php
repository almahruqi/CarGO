<?php
include 'include/connect.php';//make sure you have folder include!
?>
<?php
//get ad id
$idad =(int)$_GET['id'];
$sql = 'SELECT * FROM ads
       INNER JOIN cars ON cars.ad_id=ads.ad_id
       INNER JOIN address ON address.ad_id=ads.ad_id
       WHERE ads.ad_id = "'.$idad.'"'; //ad info
$res= mysqli_query($con, $sql);
$row =mysqli_fetch_assoc($res);//for ads
$sqlU = "SELECT * FROM user WHERE id ='$row[user_id]'";//for user info
$resU= mysqli_query($con, $sqlU);
$rowU =mysqli_fetch_assoc($resU);//for ad owner
$names=$rowU['name'].' '.$rowU['surename'];
$sqlP='SELECT * FROM upload_img WHERE ad_id="'.$idad.'"';// ad pictures
$resP= mysqli_query($con, $sqlP);
$sql2='SELECT * FROM upload_img WHERE ad_id="'.$idad.'"';
$res2= mysqli_query($con, $sql2);
/*see viewad to see how to show all the images of the ads
example of using the queries:
change the text with :
<?php echo '<p>'.$row['description'].'</p>'>?> ;*/
//print images of the car
function make_slide_idicators($res2)
{
  $count=0;
  $output = '<div class="product-img-lg bg-Blue-f5 bg1-gray-15">
    <div class="image-zoom row m-t-lg-5 m-l-lg-ab-5 m-r-lg-ab-5">';
  while ($row2=mysqli_fetch_array($res2))
  {
    if($count == 0)
    {
      $output .='												<div class="col-md-12 col-lg-12 p-lg-5">
      													<a href="photo/'.$row2['img_name'].'">
      														<img src="photo/'.$row2['img_name'].'" alt="image">
      													</a>
      												</div>

                              ';
    }
    else {
      $output .='												<div class="col-sm-3 col-md-3 col-lg-3 p-lg-5">
      													<a href="photo/'.$row2['img_name'].'">
      														<img src="photo/'.$row2['img_name'].'" alt="image">
      													</a>
      												</div>
                            ';
    }
    $count = $count+1;
  }

  return $output;
}

?>
<!DOCTYPE html>
<html lang="zxx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Car detail</title>
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
								<p class="f-14"><i class="fa fa-map-marker m-r-lg-5"></i><strong>CarGo</strong> -Long Beach / CA</p>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<ul class="pull-right">
									<li><a href="cpanel/index.php" class="icon-1"><i class="fa fa-user"></i><span>My Account</span></a></li>

											</li>
										</ul>
									</li>
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
									<i class="fa fa-phone"></i> support@cargo.x10host.com
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
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Car Listing</a>
															<ul class="dropdown-menu">

																<li><a href="car_list.php">Car List</a></li>

															</ul>

														</li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LogIn/ Register</a>
															<ul class="dropdown-menu">

																<li><a href="login.php">Login</a></li>

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

									</ul>
								</div>
								<div class="col-lg-6">
									<a href="cpanel/newad.php" class="ht-btn ht-btn-default pull-right m-t-lg-0"><i class="fa fa-upload"></i>Upload your Vehicle</a>
								</div>
							</div>
						</div>
						<!-- Car detail -->
						<section class="m-t-lg-30 m-t-xs-0">
							<div class="product_detail no-bg p-lg-0">
								<!-- Car name -->
								<?php echo '<h3 class="product-name color1-f">'.$row['name'].'

	               <span class="product-price color-red">/$'.$row['price'].' <i class="color-9 color1-9"> </i></span>
                ';?>
								</h3>
								<div class="row">
									<div class="col-md-7 col-lg-8">
										<!-- Car image gallery -->
                    <?php echo make_slide_idicators($res2);?>
                    </div>
                    </div>
									</div>
									<!-- Car description -->
									<div class="col-md-5 col-lg-4">
										<ul class="product_para-1 p-lg-15 bg-gray-f5 bg1-gray-15">
											<li><span>Make :</span><?php echo ''.$row['car_make'].'';?></li>
											<li><span>Model :</span><?php echo ''.$row['car_model'].'';?></li>
											<li><span>Seller Price :</span><?php echo '$'.$row['price'].'';?></li>
											<li><span>City :</span><?php echo ''.$row['city'].'';?></li>
											<li><span>State :</span><?php echo ''.$row['state'].'';?></li>
											<li><span>Mileage :</span><?php echo ''.$row['car_mileage'].'';?></li>
											<li><span>Added :</span><?php echo ''.$row['date'].'';?></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- Car description tabs -->
							<div class="row m-t-lg-30 m-b-lg-50">
								<div class="col-md-8">
									<div class="m-b-lg-30">
										<div class="heading-1"><h3>Overview</h3></div>
											<div class="m-b-lg-30 bg-gray-fa bg1-gray-2 p-lg-30 p-xs-15">
											<p class="color1-9">
                        <li><?php echo ''.$row['description'].'';?></li>
											</p>
										</div>
									</div>


										</div>
                    <!-- Seller Infomation -->
    								<div class="col-sm-12 col-md-4 col-lg-4">
    									<div class="heading-1">
    										<h3><i class="fa fa-info-circle"></i>Seller Infomation</h3>
    									</div>
    									</a>
    									<div class="clearfix"></div>
    									<ul class="list-default m-t-lg-0">
    										<li><i class="fa fa-user-circle-o m-r-lg-10  icon"></i><?php echo $names;?></li>
    										<li><i class="fa fa-envelope-o m-r-lg-10 icon"></i><?php echo ''.$rowU['email'].'';?></li>
    									</ul>
    								</div>
									</div>
								</div>

							</div>
			<!-- Footer-->
      <!-- Footer-->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © CarGo 2019</span>
          </div>
        </div>
      </footer>
						</div>
					</div>
				</div>
				<!-- Footer bottom -->
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
