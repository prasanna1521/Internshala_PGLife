<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | PG Life</title>
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome 5 for Navigation and Search Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Style CSS located directly in root -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar Segment -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-md-5 py-2">
    <a class="navbar-brand" href="index.php">
        <img src="images/pglife.jpg" alt="PG Life Logo" class="logo-img">
    </a>
    <div class="ml-auto d-flex align-items-center">
        <a href="signup.php" class="nav-link text-secondary small font-weight-normal mr-2">
            <i class="fas fa-user mr-1"></i> Signup
        </a>
        <a href="login.php" class="nav-link text-secondary small font-weight-normal">
            <i class="fas fa-sign-in-alt mr-1"></i> Login
        </a>
    </div>
</nav>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-heading" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login-heading">Login with PGLife</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="login_submit.php" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hero Section with Central Search Form Overlay -->
<div class="hero-banner d-flex align-items-center justify-content-center text-center">
    <div class="hero-inner-content">
        <h2 class="text-white font-weight-normal mb-4 hero-text">Happiness per Square Foot</h2>
        
        <!-- SEARCH FORM: ALWAYS DIRECTS TO LOGIN.PHP -->
        <form action="login.php" method="GET" class="search-box mx-auto">
            <div class="input-group">
                <input type="text" name="city" class="form-control border-0" placeholder="Enter your city to search for PGs" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-search-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Major Cities Column Catalog Segment -->
<div class="container my-5 text-center">
    <h3 class="text-secondary font-weight-normal mb-5 cities-section-heading">Major Cities</h3>
    
    <div class="row justify-content-center align-items-center px-lg-5">
        <!-- Delhi -->
        <div class="col-6 col-md-3 mb-4">
            <a href="login.php?city=Delhi" class="city-item-anchor text-decoration-none">
                <div class="city-frame mx-auto mb-2">
                    <img src="images/delhi.jpg" alt="Delhi landmark line art" class="city-svg-graphic">
                </div>
                <div class="city-label text-muted font-weight-normal small">DELHI</div>
            </a>
        </div>

        <!-- Mumbai -->
        <div class="col-6 col-md-3 mb-4">
            <a href="login.php?city=Mumbai" class="city-item-anchor text-decoration-none">
                <div class="city-frame mx-auto mb-2">
                    <img src="images/mumbai.jpg" alt="Mumbai landmark line art" class="city-svg-graphic">
                </div>
                <div class="city-label text-muted font-weight-normal small">MUMBAI</div>
            </a>
        </div>

        <!-- Bengaluru -->
        <div class="col-6 col-md-3 mb-4">
            <a href="login.php?city=Bengaluru" class="city-item-anchor text-decoration-none">
                <div class="city-frame mx-auto mb-2">
                    <img src="images/bengaluru.jpg" alt="Bengaluru landmark line art" class="city-svg-graphic">
                </div>
                <div class="city-label text-muted font-weight-normal small">BENGALURU</div>
            </a>
        </div>

        <!-- Hyderabad -->
        <div class="col-6 col-md-3 mb-4">
            <a href="login.php?city=Hyderabad" class="city-item-anchor text-decoration-none">
                <div class="city-frame mx-auto mb-2">
                    <img src="images/hyderabad.jpg" alt="Hyderabad landmark line art" class="city-svg-graphic">
                </div>
                <div class="city-label text-muted font-weight-normal small">HYDERABAD</div>
            </a>
        </div>
    </div>
</div>

<!-- Sticky Bottom Footer Section -->
<footer class="footer-block text-center pt-3 pb-2 mt-5">
    <div class="container">
        <div class="row justify-content-center small mb-2">
            <div class="col-auto">
                <a href="login.php?city=Delhi" class="text-light-muted px-2">PG in Delhi</a>
            </div>
            <div class="col-auto">
                <a href="login.php?city=Mumbai" class="text-light-muted px-2">PG in Mumbai</a>
            </div>
            <div class="col-auto">
                <a href="login.php?city=Bangalore" class="text-light-muted px-2">PG in Bangalore</a>
            </div>
            <div class="col-auto">
                <a href="login.php?city=Hyderabad" class="text-light-muted px-2">PG in Hyderabad</a>
            </div>
        </div>
        <div class="footer-copyright small text-muted-dark mt-2">
            &copy; 2020 Copyright PG Life
        </div>
    </div>
</footer>

</body>
</html>
