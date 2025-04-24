<?php
  session_start();
  $con = mysqli_connect('localhost', 'root', '', 'cargo');
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  mysqli_set_charset($con, "utf8");
?>
