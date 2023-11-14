<?php
include '../include/connect.php';

// Redirect to login if the user is not logged in
if (empty($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Sanitize input data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $date = date('Y-m-d H:i:s');
    $car_make = mysqli_real_escape_string($con, $_POST['car_make']);
    $car_model = mysqli_real_escape_string($con, $_POST['car_model']);
    $car_mileage = mysqli_real_escape_string($con, $_POST['car_mileage']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);

    // Validate input
    if (!empty($name) && !empty($price) && !empty($description)) {
        // Insert ad data
        $query = "INSERT INTO ads (user_id, name, description, price, date)
                  VALUES('{$_SESSION['id']}', '$name', '$description', '$price', '$date','pending')";
        mysqli_query($con, $query);

        // Get the ad_id of the inserted ad
        $ad_id = mysqli_insert_id($con);

        // Insert car data
        $query2 = "INSERT INTO cars (user_id, car_make, car_model, car_mileage, ad_id)
                   VALUES('{$_SESSION['id']}', '$car_make', '$car_model', '$car_mileage', '$ad_id')";
        mysqli_query($con, $query2);

        // Insert address data
        $query3 = "INSERT INTO address (city, state, ad_id, user_id)
                   VALUES('$city', '$state', '$ad_id', '{$_SESSION['id']}')";
        mysqli_query($con, $query3);

        header('Location: ads.php');
        exit();
    } else {
        $error_message = "Please fill in all fields";
    }
}

include 'header.php';
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Create Advertisements</li>
</ol>

<!-- Page Content -->
<div class="container-fluid">
    <h1>Create Advertisements</h1>
    <hr>

    <div class="row">
        <div class="col-md-offset-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" role="form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name" class="font-weight-bold">Ad Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="price" class="font-weight-bold">Price</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="car_make" class="font-weight-bold">Car Make</label>
                                <input name="car_make" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="car_model" class="font-weight-bold">Car Model</label>
                                <input name="car_model" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city" class="font-weight-bold">City</label>
                                <input name="city" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="state" class="font-weight-bold">State</label>
                                <select name="state" class="form-control" id="state">
                                    <option value="AL">Alabama (AL)</option>
                                    <option value="AK">Alaska (AK)</option>
                                    <option value="AZ">Arizona (AZ)</option>
                                    <option value="AR">Arkansas (AR)</option>
                                    <option value="CA">California (CA)</option>
                                    <option value="CO">Colorado (CO)</option>
                                    <option value="CT">Connecticut (CT)</option>
                                    <!-- Add more state options as needed -->
                                </select>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </form>

                    <?php
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
