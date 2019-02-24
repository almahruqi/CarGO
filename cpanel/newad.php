<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');
}

?>
<?php
if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $date=date('Y-m-d H:i:s');
  $car_make=$_POST['car_make'];
  $car_model=$_POST['car_model'];
  $car_mileage=$_POST['car_mileage'];
  $city=$_POST['city'];
  $state=$_POST['state'];


  if ($name !='' && $price !='' && $description !='' ) {
    echo $query = "INSERT INTO ads (user_id, name, description, price, date)
          VALUES('$_SESSION[id]','$name', '$description','$price', '$date'); ";
    echo $query2 = "INSERT INTO cars (user_id, car_make, car_model, car_mileage,ad_id)
                VALUES('$_SESSION[id]','$car_make', '$car_model','$car_mileage',(select ad_id from ads WHERE date='$date')); ";
    echo $query3 = "INSERT INTO address (city, state, ad_id, user_id)
                  VALUES('$city', '$state',(select ad_id from ads WHERE date='$date'),'$_SESSION[id]'); ";


    mysqli_query($con, $query);
    mysqli_query($con, $query2);
    mysqli_query($con, $query3);

    header('Location: ads.php');

  } else {
    echo "Please fill in all fields";
  }
}
 ?>

<?php
include 'header.php';
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Create Advertisments</li>
</ol>

<!-- Page Content -->
<h1>Create Advertisments</h1>
<hr>
        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-offset-3 col-lg-6">
                                <form method="post" role="form">
                                    <fieldset class="form-group">
                                        <h3 class="font-weight-bold">Ad Name</h3>
                                        <input type= "text" name="name" class="form-control">
                                        <p class="help-block">Enter the name of Ad</p>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <h3 class="font-weight-bold">Price</h2>
                                        <input type= "number" name="price" class="form-control">
                                          <p class="help-block">Enter the price of Ad</p>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <h3 class="font-weight-bold">Description</h3>
                                        <textarea name ="description"class="form-control" rows="3"></textarea>
                                          <p class="help-block">Enter the description of Ad</p>
                                    </fieldset>
                                  </fieldset>
                                  <fieldset class="form-group">
                                      <h3 class="font-weight-bold">Car Make</h3>
                                      <input name ="car_make"class="form-control"></input>
                                        <p class="help-block">Enter the Car Make</p>
                                  </fieldset>
                                </fieldset>
                                <fieldset class="form-group">
                                    <h3 class="font-weight-bold">Car Model</h3>
                                    <input name ="car_model"class="form-control"></input>
                                      <p class="help-block">Enter the the car model</p>
                                </fieldset>
                              </fieldset>
                              <fieldset class="form-group">
                                  <h3 class="font-weight-bold">Mileage</h3>
                                  <input type="number" name ="car_mileage"class="form-control"></input>
                                    <p class="help-block">Enter the Mileage of the Car</p>
                              </fieldset>
                              <fieldset class="form-group">
                                  <h3 class="font-weight-bold">city</h3>
                                  <input  name ="city"class="form-control"></input>
                                    <p class="help-block">Enter the Mileage of the Car</p>
                              </fieldset>
                              <fieldset class="form-group">
                                  <label for="States" class="font-weight-bold">States</label>
                                  <select name="state" class="form-control" id="States">
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

                                    <button type="submit" name="submit" class="btn btn-secondary">Submit Button</button>
                                    <button type="reset" class="btn btn-secondary">Reset Button</button>
                                    </form>

      </div>
      </div>
      <!-- /.container-fluid -->
      <?php
      include 'footer.php';
      ?>
