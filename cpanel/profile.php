<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: warning.php');
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
<h1>Profile Page</h1>
<hr>
        <!-- Page Content -->
        <div class="content mt-5 pt-5">
              <?php
              //To view user information
              $user_id = $_SESSION['id'];
              $sql = "SELECT * FROM user WHERE id='$user_id'";
              $res= mysqli_query($con, $sql);
              if (mysqli_num_rows($res) > 0)
              {
                while ($row =mysqli_fetch_assoc($res)) {
                    echo '
                    <div class="row">
                        <div class="col-md-offset-3 col-lg-6 ">
                            <form method="post" role="form" action="save_edit_profile.php" enctype="multipart/form-data" method="post">
                            <fieldset class="form-group">User Name</h3>
                                <td><input type= "text" name="name" class="form-control" value="'.$row['name'].'" readonly></td>
                            </fieldset>
                            <fieldset class="form-group">User Last Name</h3>
                                <td><input type= "text" name="lastname" class="form-control" value="'.$row['surename'].'" readonly></td>
                            </fieldset>
                            <fieldset class="form-group">Email Address</h3>
                                <td><input type="email" name="email" class="form-control" value='.$row['email'].'></td>
                            </fieldset>
                            <fieldset class="form-group">Password</h3>
                                <td>  <input type="password" name="password" class="form-control" placeholder="Password" required="required" id="psw"
                                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                  <h4><b>Password must contain the following:</b></h4>
                                  <p><b>lowercase</b> letter</p>
                                  <p>A <b>capital (uppercase)</b> letter</p>
                                  <p>A <b>number</b></p>
                                  <p>Minimum <b>8 characters</b></p>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                                </div>
                                </td>
                            </fieldset>
                            <input type="hidden" name="id" value='.$row['id'].' />
                            <input class="btn btn-primary" name="enter" type="submit" value="Edit">
                            <a href="index.php" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Go HomePage</a>


                    ';}
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
