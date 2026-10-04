<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $college_name = trim($_POST['college_name']);
    $gender = $_POST['gender'] ?? '';

    // Check if email already exists using a prepared statement
    $check_stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "Email address is already registered!";
    } else {
        // Hash password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (full_name, phone, email, password, college_name, gender) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insert_stmt, "ssssss", $full_name, $phone, $email, $hashed_password, $college_name, $gender);

        if (mysqli_stmt_execute($insert_stmt)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['full_name'] = $full_name;

            // Redirect to properties or login
            header("Location: properties.php");
            exit();
        } else {
            $message = "Something went wrong! Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup with PGLife</title>

    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .signup-card {
            max-width: 440px;
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
            background-color: #ffffff;
            border-left: 0;
        }
        .form-control-styled-blue {
            background-color: #eaf2fd;
            border-left: 0;
        }
        .form-control-styled:focus, .form-control-styled-blue:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
    <div class="card signup-card p-4 w-100 bg-white">

        <!-- Header close row matching modal UI -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0 font-weight-bold text-secondary">Signup with PGLife</h5>
            <a href="index.php" class="text-muted text-decoration-none h4 mb-0">&times;</a>
        </div>

        <?php if ($message != "") { ?>
            <div class="alert alert-danger py-2 small">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>

        <form method="POST">

            <!-- Full Name -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="full_name" class="form-control form-control-styled" placeholder="Full Name" required>
            </div>

            <!-- Phone Number -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                </div>
                <input type="tel" name="phone" class="form-control form-control-styled" placeholder="Phone Number" required>
            </div>

            <!-- Email -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" class="form-control form-control-styled-blue" placeholder="Email" required>
            </div>

            <!-- Password -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control form-control-styled-blue" placeholder="Password" required>
            </div>

            <!-- College Name -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                </div>
                <input type="text" name="college_name" class="form-control form-control-styled" placeholder="College Name" required>
            </div>

            <!-- Gender Radio Options -->
            <div class="mb-3 text-muted small">
                <span class="mr-3">I'm a</span>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>

            <!-- Create Account Button -->
            <button type="submit" class="btn btn-pglife btn-block mt-3 py-2">
                Create Account
            </button>

            <!-- Login Redirect Link -->
            <div class="text-center mt-4 small">
                <span class="text-muted">Already have an account? </span>
                <a href="login.php" class="text-info font-weight-bold">Login</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
