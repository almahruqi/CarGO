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
<h1>Advertisments</h1>
<hr>
        <!-- Page Content -->
        <div class="card-body">
          <div class="table-responsive">
            <h2>Advertisments by the users</h2>

              <?php

              $id = '';

              if (isset($_GET['id']) && $_GET['id']!= '') {
                $id = 'WHERE user_id ="'.$_GET['id'].'"';

              }
              if ($_SESSION['role'] == 'user') {
                $id='WHERE user_id ="'.$_SESSION['id'].'"';
              }


              $sql = 'SELECT * FROM ads '.$id.'';
              $res= mysqli_query($con, $sql);

              if (mysqli_num_rows($res) > 0)
              {
                echo '
                <table class="table table-bordered table table-striped " id="table_id" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Ad Name</th>
                      <th>Date Listed</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  ';
                  while ($row =mysqli_fetch_assoc($res)) {


                    $sql1 = "SELECT * FROM user WHERE id ='$row[user_id]'";
                    $res1= mysqli_query($con, $sql1);
                    $row1= mysqli_fetch_assoc($res1);

                    $names=$row1['name'].' '.$row1['surename'];
                    //for view ad
                    $Vbutton = '<a href="viewad.php?id='.$row['ad_id'].'"   class="text-light btn btn-primary fa fa-eye"><span></span> View</a>';
                    $Abutton = '<a href="upload.php?id='.$row['ad_id'].'"   class="btn btn-info"><span></span> Add a photo</a>';
                    $Editbutton = '<a href="edit.php?id='.$row['ad_id'].'"   class="btn btn-secondary"><span></span> Edit</a>';
                    echo '
                    <tr>
                      <td >'.$row['ad_id'].'</td>
                      <td>'.$names.'</td>
                      <td>'.$row['name'].'</td>
                      <td>'.date('M d, Y', strtotime($row['date'])).'</td>
                      <td>'.$row['status'].'</td>
                      <td>
                      <a href="adsdelete.php?id='.$row['ad_id'].'"  class="btn btn-danger"><span></span> Delete</a>
                      '.$Vbutton.' '.$Editbutton.' '.$Abutton.'
                      </td>
                    </tr>
                    ';
                  }
                  echo '
                  </tbody>
                  </table>
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

 <script>
       $(document).ready(function() {
         $('#table_id').DataTable();
      } );
</script>
