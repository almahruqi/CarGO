<?php
include '../include/connect.php';
if ($_SESSION['id'] == '') {
  header('Location: ../login.php');
}
if ($_SESSION['role'] == 'user') {
  header('Location:index.php');
}
//change role method
if (isset($_GET['id'])) {
   $id =(int)$_GET['id'];
   if ($id != '') {
    $sqlR = 'SELECT * FROM user WHERE id ='.$id.'';
    $resR= mysqli_query($con, $sqlR);
    $rowR= mysqli_fetch_assoc($resR);
        if ($rowR[role]=='user') {
        $sqlR='UPDATE user SET role ="admin" WHERE id="'.$id.'"';
        mysqli_query($con, $sqlR);
      }
       else {
         $sqlR='UPDATE user SET role ="user" WHERE id="'.$id.'"';
        mysqli_query($con, $sqlR);
       }


  }
}

//Delete user

?>
<?php
include 'header.php';
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Users</li>
</ol>

<!-- Page Content -->
<h1>List of the Users</h1>
<hr>
        <div class="card-body">
          <div class="table-responsive">
            <h2>Users List</h2>

              <?php
              $sql = "SELECT * FROM user";
              $res= mysqli_query($con, $sql);

              if (mysqli_num_rows($res) > 0)
              {
                echo '
                <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>User Role</th>
                      <th>Name</th>
                      <th>Surename</th>
                      <th>Email</th>
                      <th>Number of posted Ads</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                  ';
                  while ($row =mysqli_fetch_assoc($res)) {

                    $sql1 = "SELECT * FROM ads WHERE user_id ='$row[id]'";
                    $res1= mysqli_query($con, $sql1);
                    $num= mysqli_num_rows($res1);

                    $button = '<a href="?id='.$row['id'].'"  class="btn btn-warning"><span></span> Change Role</a>';
                    $Dbutton = '<a href="delete.php?id='.$row['id'].'"  class="btn btn-danger"><span></span> Delete</a>';

                    echo '

                    <tr>
                      <td>'.$row['id'].'</td>
                      <td>'.$row['role'].'</td>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['surename'].'</td>
                      <td>'.$row['email'].'</td>
                      <td>'.$num.'</td>
                      <td class="pull-right">
                      <a href="ads.php?id='.$row['id'].'" class="text-light btn btn-primary"><span class="fa fa-eye"></span>View Ads</a>
                      '.$button.' '.$Dbutton.'
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
