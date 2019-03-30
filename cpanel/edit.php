<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: warning.php');
}
$idad =(int)$_GET['id'];
if ($idad == '0')
{
  header('Location: ads.php');
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
                while ($row =mysqli_fetch_assoc($res)) {
                    echo '
                    <div class="row">
                        <div class="col-md-offset-3 col-lg-6 ">
                            <form method="post" role="form" action="save_edit.php" enctype="multipart/form-data" method="post">
                                <fieldset class="form-group">
                                    <h3 class="font-weight-bold">Ad Name</h3>
                                    <td><input type= "text" name="name" class="form-control" value="'.$row['name'].'" "/></td>
                                    <p class="help-block">Enter the name of Ad</p>
                                </fieldset>

                                <fieldset class="form-group">
                                    <h3 class="font-weight-bold">Price</h2>
                                    <input type= "number" name="price" class="form-control" value='.$row['price'].'>
                                      <p class="help-block">Enter the price of Ad</p>
                                </fieldset>
                                <fieldset class="form-group">
                                    <h3 class="font-weight-bold">Description</h3>
                                <textarea name ="description" class="form-control " rows="3">'.$row['description'].'</textarea>
                                      <p class="help-block">Enter the description of Ad</p>
                                </fieldset>
                              </fieldset>
                              <fieldset class="form-group">
                                  <h3 class="font-weight-bold">Car Make</h3>
                                  <input name ="car_make"class="form-control" value='.$row['car_make'].'></input>
                                    <p class="help-block">Enter the Car Make</p>
                              </fieldset>
                            </fieldset>
                            <fieldset class="form-group">
                                <h3 class="font-weight-bold">Car Model</h3>
                                <input name ="car_model"class="form-control" value='.$row['car_model'].'></input>
                                  <p class="help-block">Enter the the car model</p>
                            </fieldset>
                          </fieldset>
                          <fieldset class="form-group">
                              <h3 class="font-weight-bold">Mileage</h3>
                              <input type="number" name ="car_mileage"class="form-control" value='.$row['car_mileage'].'></input>
                                <p class="help-block">Enter the Mileage of the Car</p>
                          </fieldset>
                          <fieldset class="form-group">
                              <h3 class="font-weight-bold">city</h3>
                              <input  name ="city"class="form-control" value='.$row['city'].'></input>
                                <p class="help-block">Enter the Mileage of the Car</p>
                          </fieldset>
                          <fieldset class="form-group">
                              <label for="States" class="font-weight-bold">States</label>
                              <select name="state" class="form-control" id="States" value='.$row['state'].'>
                                <option value="AL">Alabama (AL)</option>
                                <option value="AK">Alaska (AK)</option>
                                <option value="AZ">Arizona (AZ)</option>
                                <option value="AR">Arkansas (AR)</option>
                                <option value="CA">California (CA)</option>
                                <option value="CO">Colorado (CO)</option>
                                <option value="CT">Connecticut (CT)</option>
                                <option value="DE">Delaware (DE)</option>
                                <option value="DC">District Of Columbia (DC)</option>
                                <option value="FL">Florida (FL)</option>
                                <option value="GA">Georgia (GA)</option>
                                <option value="HI">Hawaii (HI)</option>
                                <option value="ID">Idaho (ID)</option>
                                <option value="IL">Illinois (IL)</option>
                                <option value="IN">Indiana (IN)</option>
                                <option value="IA">Iowa (IA)</option>
                                <option value="KS">Kansas (KS)</option>
                                <option value="KY">Kentucky (KY)</option>
                                <option value="LA">Louisiana (LA)</option>
                                <option value="ME">Maine (ME)</option>
                                <option value="MD">Maryland (MD)</option>
                                <option value="MA">Massachusetts (MA)</option>
                                <option value="MI">Michigan (MI)</option>
                                <option value="MN">Minnesota (MN)</option>
                                <option value="MS">Mississippi (MS)</option>
                                <option value="MO">Missouri (MO)</option>
                                <option value="MT">Montana (MT)</option>
                                <option value="NE">Nebraska (NE)</option>
                                <option value="NV">Nevada (NV)</option>
                                <option value="NH">New Hampshire (NH)</option>
                                <option value="NJ">New Jersey (NJ)</option>
                                <option value="NM">New Mexico (NM)</option>
                                <option value="NY">New York (NY)</option>
                                <option value="NC">North Carolina (NC)</option>
                                <option value="ND">North Dakota (ND)</option>
                                <option value="OH">Ohio (OH)</option>
                                <option value="OK">Oklahoma (OK)</option>
                                <option value="OR">Oregon (OR)</option>
                                <option value="PA">Pennsylvania (PA)</option>
                                <option value="RI">Rhode Island (RI)</option>
                                <option value="SC">South Carolina (SC)</option>
                                <option value="SD">South Dakota (SD)</option>
                                <option value="TN">Tennessee (TN)</option>
                                <option value="TX">Texas (TX)</option>
                                <option value="UT">Utah (UT)</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                                <p class="help-block">Enter the state</p>
                          </fieldset>

                          <input type="hidden" name="id" value='.$row['ad_id'].' />
                          <input name="enter" type="submit" value="Edit">


  </div>
  </div> ';}
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
