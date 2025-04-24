<?php
include '../include/connect.php';

// Redirect to login if the user is not logged in
if (empty($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

// Get the user id
$userID = $_SESSION['id'];

// Query to get the total number of ads posted by the user
$sqlTotalAds = 'SELECT COUNT(*) AS total_ads FROM ads WHERE user_id="' . $userID . '"';
$resTotalAds = mysqli_query($con, $sqlTotalAds);
$rowTotalAds = mysqli_fetch_assoc($resTotalAds);
$countTotalAds = ($rowTotalAds ? $rowTotalAds['total_ads'] : 0);

// Query to get the last ad posted by the user
$sqlLastAd = 'SELECT * FROM ads WHERE user_id="' . $userID . '" ORDER BY date DESC LIMIT 1';
$resLastAd = mysqli_query($con, $sqlLastAd);
$rowLastAd = mysqli_fetch_assoc($resLastAd);
$lastAdName = ($rowLastAd ? $rowLastAd['name'] : '');

// Query to get the total number of approved ads posted by the user
$sqlApprovedAds = 'SELECT COUNT(*) AS approved_ads FROM ads WHERE user_id="' . $userID . '" AND status="approved"';
$resApprovedAds = mysqli_query($con, $sqlApprovedAds);
$rowApprovedAds = mysqli_fetch_assoc($resApprovedAds);
$countApprovedAds = ($rowApprovedAds ? $rowApprovedAds['approved_ads'] : 0);

// Query to get the total number of pending ads posted by the user
$sqlPendingAds = 'SELECT COUNT(*) AS pending_ads FROM ads WHERE user_id="' . $userID . '" AND status="pending"';
$resPendingAds = mysqli_query($con, $sqlPendingAds);
$rowPendingAds = mysqli_fetch_assoc($resPendingAds);
$countPendingAds = ($rowPendingAds ? $rowPendingAds['pending_ads'] : 0);
?>

<?php include 'header.php'; ?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Home</li>
</ol>

<!-- Page Content -->
<div class="container-fluid">
    <h1>Home</h1>
    <hr>

    <!-- Icon Cards-->
    <div class="row">
        <?php if ($countTotalAds > 0) : ?>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-info o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <p class="font-weight-bold h1"><?php echo $countTotalAds; ?></p>
                        <div class="mr-5">Total Ads You Posted</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="ads.php">
                        <span class="float-left">Click here to view your advertisements</span>
                        <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card bg-light o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <?php if ($countTotalAds > 0) : ?>
                        <p class="font-weight-bold h3"><?php echo ($lastAdName != '' ? $lastAdName : 'No Ads Posted Yet!'); ?></p>
                        <div class="mr-5"><?php echo ($lastAdName != '' ? 'Is Your Last Ad You Posted!' : 'You haven\'t posted any ads yet.'); ?></div>
                    <?php else : ?>
                        <p class="font-weight-bold h3">No Ads Posted Yet!</p>
                        <div class="mr-5">You haven't posted any ads yet.</div>
                    <?php endif; ?>
                </div>
                <a class="card-footer text-dark  clearfix small z-1" href="newad.php">
                    <span class="float-left">
                        <?php echo ($countTotalAds > 0 ? 'Click here to post a new advertisement' : 'Start posting ads now!'); ?>
                    </span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <?php if ($countApprovedAds > 0) : ?>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <p class="font-weight-bold h1"><?php echo $countApprovedAds; ?></p>
                        <div class="mr-5">Total Ads You Posted Approved</div>
                    </div>
                    <a class="card-footer bg-danger text-white clearfix">
                        <span class="float-left">You have <?php echo $countPendingAds; ?> ads pending.</span>
                        <span class="float-right">
                        </span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
