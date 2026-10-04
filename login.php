<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and sanitize inputs / Prevent SQL injection using prepared statements
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'] ?? $user['name'];

            // Preserve city search redirect if parameter exists
            $redirect_city = isset($_GET['city']) ? '?city=' . urlencode($_GET['city']) : '';
            header("Location: properties.php" . $redirect_city);
            exit();

        } else {
            $message = "Incorrect password!";
        }

    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with PGLife</title>
    
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            max-width: 400px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .btn-pglife {
            background-color: #36b9b8;
            border-color: #36b9b8;
            color: #ffffff;
            font-weight: 500;
        }
        .btn-pglife:hover {
            background-color: #2da1a0;
            color: #ffffff;
        }
        .input-group-text {
            background-color: #f1f5f9;
            border-right: 0;
            color: #6c757d;
        }
        .form-control-styled {
            background-color: #eaf2fd;
            border-left: 0;
        }
        .form-control-styled:focus {
            background-color: #eaf2fd;
            box-shadow: none;
            border-color: #ced4da;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card login-card p-4 w-100 bg-white">

        <!-- Header close row matching modal UI -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0 font-weight-bold text-secondary">Login with PGLife</h5>
            <a href="index.php" class="text-muted text-decoration-none">&times;</a>
        </div>

        <?php if ($message != "") { ?>
            <div class="alert alert-danger py-2 small">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>

        <form method="POST">

            <!-- Email Field with Icon -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="email" name="email" class="form-control form-control-styled" placeholder="Email" required>
            </div>

            <!-- Password Field with Icon -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control form-control-styled" placeholder="Password" required>
            </div>

            <!-- Submit Button matching 51835.jpg -->
            <button type="submit" class="btn btn-pglife btn-block mt-3 py-2">
                Login
            </button>

            <!-- Registration Link -->
            <div class="text-center mt-4 small">
                <span class="text-muted">Click here to </span>
                <a href="signup.php" class="text-info font-weight-bold">register a new account</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
