<?php
ob_start();
include('include/connect.php');

// Check if a session is not already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Add CSRF protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Rate limiting
$ip = $_SERVER['REMOTE_ADDR'];
$login_attempts = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] : 0;
$last_attempt = isset($_SESSION['last_attempt']) ? $_SESSION['last_attempt'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        handleLoginError("Invalid request");
        exit;
    }

    // Check rate limiting
    if ($login_attempts >= 5 && (time() - $last_attempt) < 300) { // 5 attempts in 5 minutes
        handleLoginError("Too many login attempts. Please try again later.");
        exit;
    }

    handleLoginForm($con);
}

function handleLoginForm($con) {
    global $login_attempts, $last_attempt;
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
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
                // Reset login attempts on successful login
                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_attempt'] = 0;
                
                // Set secure session parameters
                session_regenerate_id(true);
                $_SESSION['id'] = $details['id'];
                $_SESSION['name'] = $details['name'];
                $_SESSION['surename'] = $details['surename'];
                $_SESSION['email'] = $details['email'];
                $_SESSION['role'] = $details['role'];
                $_SESSION['last_activity'] = time();
                
                // Set secure cookies
                setcookie('PHPSESSID', session_id(), [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
                
                header('Location: cpanel/index.php');
                exit;
            } else {
                incrementLoginAttempts();
                handleLoginError("Invalid email or password");
            }
        } else {
            incrementLoginAttempts();
            handleLoginError("Invalid email or password");
        }
    } else {
        incrementLoginAttempts();
        handleLoginError("Please fill in all fields");
    }
}

function incrementLoginAttempts() {
    $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
    $_SESSION['last_attempt'] = time();
}

function handleLoginError($errorMessage) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . htmlspecialchars($errorMessage) . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    ';
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
    <!-- Font Awesome -->
    <link href="assets/css/all.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/login.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="assets/img/logo.png" alt="CarGo Logo" class="mb-3" style="max-width: 150px;">
                            <h4 class="card-title">Welcome to CarGo</h4>
                            <p class="text-muted">Please sign in to continue</p>
                        </div>
                        <form method="post" role="form" id="loginForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Email address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </button>
                        </form>
                        <div class="mt-3 text-center">
                            <a class="d-block small" href="register.php">Create an account</a>
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
    <script src="assets/js/all.min.js"></script>
    <script>
        // Add form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = this.querySelector('input[name="email"]');
            const password = this.querySelector('input[name="password"]');
            
            if (!email.value || !password.value) {
                e.preventDefault();
                alert('Please fill in all fields');
            }
        });
    </script>
</body>

</html>
