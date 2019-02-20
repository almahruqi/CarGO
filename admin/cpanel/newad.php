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
  if ($name !='' && $price !='' && $description !='' ) {

    echo $query = "INSERT INTO ads (user_id, name, description, price, date)
          VALUES('$_SESSION[id]','$name', '$description','$price', '$date')";
    mysqli_query($con, $query);
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

                                    <button type="submit" name="submit" class="btn btn-secondary">Submit Button</button>
                                    <button type="reset" class="btn btn-secondary">Reset Button</button>
                                    </form>

      </div>
      </div>
      <!-- /.container-fluid -->
      <?php
      include 'footer.php';
      ?>
