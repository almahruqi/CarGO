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
                <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Date Listed</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  ';
                  while ($row =mysqli_fetch_assoc($res)) {


                    $sql1 = "SELECT * FROM user WHERE id ='$row[user_id]'";
                    $res1= mysqli_query($con, $sql1);
                    $row1= mysqli_fetch_assoc($res1);

                    $names=$row1['name'].' '.$row1['surename'];

                    echo '
                    <tr>
                      <td>'.$row['id'].'</td>
                      <td>'.$names.'</td>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['description'].'</td>
                      <td>'.$row['price'].'</td>
                      <td>'.date('M d, Y', strtotime($row['date'])).'</td>
                      <td>
                      <a href="adsdelete.php?id='.$row['id'].'"  class="btn btn-danger"><span></span> Delete</a>
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
