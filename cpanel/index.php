<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');
}
?>
<?php
include 'header.php';
?>
<?php
//get the user id and then make query to display num of ads of the user
$userID= $_SESSION['id'];
//the query
$sql = 'SELECT * FROM ads WHERE user_id="'.$userID.'" ';
$res= mysqli_query($con, $sql);
$count = mysqli_num_rows($res);
$sqlLast = 'SELECT * FROM ads WHERE user_id="'.$userID.'" ORDER BY date LIMIT 1';
$res2= mysqli_query($con, $sqlLast);
$row2= mysqli_fetch_array($res2);
$ad_name=$row2['name'];
$sql3 = 'SELECT * FROM ads WHERE user_id="'.$userID.'" AND status="approved"';
$res3= mysqli_query($con, $sql3);
$count3 = mysqli_num_rows($res3);
$sql4 = 'SELECT * FROM ads WHERE user_id="'.$userID.'" AND status="pending"';
$res4= mysqli_query($con, $sql4);
$count4 = mysqli_num_rows($res4);
 ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Home</li>
</ol>

<!-- Page Content -->
<h1>Home</h1>
<hr>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <p class="font-weight-bold h1"><?php echo $count;?></p>
                <div class="mr-5">Total Ad You Posted</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="ads.php">
                <span class="float-left">click here to view your advertisement</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-light o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <p class="font-weight-bold h3"><?php
                if($ad_name == '')
                {echo"NO ADS";}
                else
                {echo $ad_name;}?></p>
                <div class="mr-5">Is Your Last Ad You Posted!</div>
              </div>
              <a class="card-footer text-dark  clearfix small z-1" href="newad.php">
                <span class="float-left">click here to post a new advertisement</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <p class="font-weight-bold h1"><?php echo $count3;?></p>
                <div class="mr-5">Total Ad You Posted Approved</div>
              </div>
              <a class="card-footer bg-danger text-white clearfix ">
                <span class="float-left">You have <?php echo $count4;?> have Pending.</span>
                <span class="float-right">
                </span>
              </a>
            </div>
          </div>
        </div>

      <!-- /.container-fluid -->
<?php
include 'footer.php';
?>
