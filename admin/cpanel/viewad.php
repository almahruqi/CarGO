<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');
}
?>

<?php
include 'header.php';
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Advertisments</li>
</ol>

<!-- Page Content -->
<h1>Advertisment</h1>
<hr>
        <!-- Page Content -->
        <div class="content mt-5 pt-5">
              <?php
              //To view one advertisments for user and only what user advertise
              $idad =(int)$_GET['id'];
              if ($_SESSION['role'] == 'user') {
                  $id='AND ads.user_id ="'.$_SESSION['id'].'"';
                  $sql = 'SELECT * FROM ads
                         INNER JOIN cars ON cars.ad_id=ads.ad_id
                         INNER JOIN address ON address.ad_id=ads.ad_id
                         WHERE ads.ad_id = "'.$idad.'" '.$id.'';
                  //$sql = 'SELECT * FROM ads'.$id.' AND ad_id='.$idad.' ';
              }
              //To view Any one advertisment
              else if ($_SESSION['role'] == 'admin') {
                //
                // $sql = 'SELECT * FROM ads  JOIN cars ON cars.ad_id="'.$idad.'" AND ads.ad_id="'.$idad.'"
                //   JOIN address ON address.ad_id="'.$idad.'" ';
                $sql = 'SELECT * FROM ads
                       INNER JOIN cars ON cars.ad_id=ads.ad_id
                       INNER JOIN address ON address.ad_id=ads.ad_id
                       WHERE ads.ad_id = "'.$idad.'"';





              }
              else {
                session_destroy();
                echo '
                <div class="alert_loging">
                  <div id="myAlert" class="alert alert-danger font-weight-bold text-center">
                      <strong>YOU DONNOT HAVE ACCESS!</strong>
                  </div>
                ';
                header('Location: ../login.php');
              }

              $res= mysqli_query($con, $sql);

              if (mysqli_num_rows($res) > 0)
              {
                echo '

  						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
  							<li class="nav-item">
  								<a class="nav-link active" id="pills-desciption-tab" data-toggle="pill" href="#pills-desciption" role="tab" aria-controls="pills-home"
  								 aria-selected="true">Car Description </a>
  							</li>
  							<li class="nav-item">
  								<a class="nav-link" id="pills-specifictatione-tab" data-toggle="pill" href="#pills-specifictatione" role="tab" aria-controls="pills-specifictatione"
  								 aria-selected="false">Car Specifications</a>
  							</li>
  							<li class="nav-item">
  								<a class="nav-link" id="pills-action-tab" data-toggle="pill" href="#pills-action" role="tab" aria-controls="pills-action"
  								 aria-selected="false">Action</a>
  							</li>
  						</ul>
              <div class="tab-content" id="pills-tabContent">

                  ';
                  while ($row =mysqli_fetch_assoc($res)) {
                    $Editbutton = '<a href="edit.php?id='.$row['ad_id'].'"  class="btn btn-secondary"><span></span> Edit</a>';
                    echo '
                    <div class="tab-pane  fade" id="pills-desciption" role="tabpanel" aria-labelledby="pills-desciption-tab">
      								<h3 class="tab-title">Car Description</h3>
                      <tr>
                      <td>'.$row['description'].'</td>
                      </tr>
                      </div>

							<div class="tab-pane fade" id="pills-specifictatione" role="tabpanel" aria-labelledby="pills-specifictatione-tab">
								<h3 class="tab-title">Car Specifications</h3>
								<table class="table table-bordered product-table">
									<tbody>
										<tr>
											<td>Seller Price</td>
											<td>$'.$row['price'].'</td>
										</tr>
										<tr>
											<td>Added</td>
											<td>'.date('M d, Y', strtotime($row['date'])).'</td>
										</tr>
                    <tr>
											<td>Make</td>
											<td>'.$row['car_make'].'</td>
										</tr>
                    <tr>
											<td>Model</td>
											<td>'.$row['car_model'].'</td>
										</tr>
                    <tr>
											<td>Mileage</td>
											<td>'.$row['car_mileage'].'</td>
										</tr>
										<tr>
											<td>State</td>
											<td>'.$row['state'].'</td>
										</tr>
										<tr>
											<td>city</td>
												<td>'.$row['city'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
              <div class="tab-pane fade" id="pills-action" role="tabpanel" aria-labelledby="pills-action-tab">
								<h3 class="tab-title">Actions</h3>
									<tbody>

                  <td>
                  <a href="adsdelete.php?id='.$row['ad_id'].'"  class="btn btn-danger"><span></span> Delete</a>
                  '.$Abutton.'
                  </td>

							</div> ';}
                  echo '
                  </tbody>
                  ';
                } else {

                }
              ?>


              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
      <?php

include 'footer.php';
       ?>
