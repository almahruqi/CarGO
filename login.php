<?php
ob_start();
include('include/connect.php');

// Check if a session is not already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handleLoginForm($con);
}

function handleLoginForm($con) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            $details = mysqli_fetch_assoc($res);
            if (password_verify($password, $details['password'])) {
                $_SESSION['id'] = $details['id'];
                $_SESSION['name'] = $details['name'];
                $_SESSION['surename'] = $details['surename'];
                $_SESSION['email'] = $details['email'];
                $_SESSION['role'] = $details['role'];
                header('Location: cpanel/index.php');
            } else {
                handleLoginError("Your password you entered was incorrect!");
            }
        } else {
            handleLoginError("The E-mail address or password you entered was incorrect!");
        }
    } else {
        session_destroy();
        handleLoginError("Please fill in all fields");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CarGo - Login</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/login.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Login</h5>
                        <form method="post" role="form">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="E-mail address" required="required">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                            <?php 
                            function handleLoginError($errorMessage) {
                                echo '
                                <div class="mt-3 text-center">
                                <span class="badge badge-pill badge-danger"><h5><strong>Error!</strong> ' . $errorMessage . '</span></h5>
                                </div>
                                ';
                            }
                            ?>
                        </form>
                        <div class="mt-3 text-center">
                            <a class="d-block small" href="register.php">Register new account?</a>
                            <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
