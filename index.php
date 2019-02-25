<?php
include('include/connect.php');

 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bootstrap Photo Gallery Demo</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <link href="assets/css/jquery.bsPhotoGallery-min.css" rel="stylesheet">
    <script src="assets/js/jquery.bsPhotoGallery-min.js"></script>

    </script>
    <script>
    $(document).ready(function(){
      $('ul.first').bsPhotoGallery({
        "classes" : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
        "hasModal" : true,
        // "fullHeight" : false
      });
    });
    </script>
  </head>
  <style>
      /**************STYLES ONLY FOR DEMO PAGE**************/
      @import url(https://fonts.googleapis.com/css?family=Bree+Serif);
      body {
        background:#ebebeb;
      }
  </style>
  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">CarGo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Registation</a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    </ul>
  </div>
</nav>
        <div class="row" style="text-align:center; border-bottom:1px dashed #ccc;  padding:30px 0 20px 0; margin-bottom:40px;">
            <div class="col-lg-12">
            <h3 style="font-family:'Bree Serif', arial; font-weight:bold; font-size:30px;">
                <a style="text-decoration:none; color:#666;">Tester of CarGo</a>
            </h3>
            <p> View ADS </p>
            </div>

        <ul class="row first" >
          <?php
          $sql = 'SELECT * FROM ads '.$id.'WHERE status="approved" ';
          $res= mysqli_query($con, $sql);
          if (mysqli_num_rows($res) > 0) {
            echo '
              <li>
              ';

while ($row =mysqli_fetch_assoc($res)) {
  $sql1 = "SELECT * FROM user WHERE id ='$row[user_id]'";
  $res1= mysqli_query($con, $sql1);
  $row1= mysqli_fetch_assoc($res1);

  $names=$row1['name'].' '.$row1['surename'];
  echo '
    <p>'.$row[name].'</p>
    <div class="text">'.$row[description].'<span class="pull-right">Uploaded by:'.$names.'</span</div>
  ';
}
              echo '
                </li>
                ';





          } else {
            echo '
            <li>
                <p>Sorry there is no ads</p>
            </li>
            ';
          }

           ?>

  </ul>
    </div> <!-- /container -->
  </body>
</html>