<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all properties
$query = "SELECT * FROM properties";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG Life - Properties</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .properties-container {
            max-width: 850px;
            margin: 0 auto;
        }

        /* Side-by-side Layout Framework */
        .property-card {
            border: 1px solid #deedea;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            background-color: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .property-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        /* Fixed image thumbnail sizing to stop stretching */
        .property-card img {
            width: 100%;
            height: 100%;
            min-height: 210px;
            max-height: 240px;
            object-fit: cover;
        }

        .logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        .rating-stars {
            color: #ff385c;
            font-size: 0.9rem;
        }

        .interested-text {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Custom Badges */
        .gender-badge-girls {
            color: #ff385c;
            border: 1px solid #ff385c;
            background-color: #fff5f6;
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .gender-badge-boys {
            color: #007bff;
            border: 1px solid #007bff;
            background-color: #f0f7ff;
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .card-footer-row {
            border-top: 1px solid #f2f2f2;
            padding-top: 12px;
            margin-top: auto; /* Pushes the price and button to the very bottom */
        }

        .price-amount {
            font-size: 1.3rem;
            font-weight: 800;
            color: #2c2c2c;
        }

        .btn-view-details {
            background-color: #1d72b8;
            border-color: #1d72b8;
            color: #ffffff;
            font-weight: 600;
            padding: 6px 24px;
        }

        .btn-view-details:hover {
            background-color: #145285;
            border-color: #145285;
            color: #ffffff;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 w-100 mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        
        <!-- FIXED: Links to dashboard.php so clicking logo doesn't throw user back -->
        <a class="navbar-brand d-flex align-items-center py-0" href="javascript:void(0);" style="cursor: default;">
            <img src="images/pglife.jpg" alt="PG Life Logo" class="logo-img">
        </a>

        <!-- FIXED: Bootstrap 5 classes (ms-auto, me-4, me-3, me-1) keep items locked right -->
        <div class="d-flex align-items-center ms-auto">
            <span class="welcome-text me-4 font-weight-bold text-dark">
                Welcome, <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Lakshmi Aila'; ?> 👋
            </span>

            <a href="dashboard.php" class="btn btn-primary btn-sm me-3 font-weight-bold px-3">
                <i class="fas fa-heart me-1"></i> My Shortlist <span class="badge bg-light text-primary ms-1">1</span>
            </a>

            <a href="logout.php" class="btn btn-outline-danger btn-sm font-weight-bold px-3">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>

    </div>
</nav>

<div class="container properties-container">

    <div class="row g-2 mb-4 bg-white p-3 border rounded shadow-sm align-items-center">
        <div class="col-md-1 text-secondary font-weight-bold small">
            <i class="fas fa-filter me-1"></i>Filter:
        </div>
        <div class="col-md-3">
            <select id="cityFilter" class="form-select form-select-sm">
                <option value="">All Cities</option>
                <option value="Hyderabad">Hyderabad</option>
                <option value="Bangalore">Bangalore</option>
                <option value="Mumbai">Mumbai</option>
            </select>
        </div>

        <div class="col-md-3">
            <select id="genderFilter" class="form-select form-select-sm">
                <option value="">All Genders</option>
                <option value="Boys">Boys</option>
                <option value="Girls">Girls</option>
            </select>
        </div>

        <div class="col-md-3">
            <input
                type="number"
                id="budgetFilter"
                class="form-control form-select-sm"
                placeholder="Max Budget (e.g. 10000)">
        </div>
        
        <div class="col-md-2 text-end small">
            <a href="#" class="text-decoration-none text-dark fw-bold me-2"><i class="fas fa-sort-amount-up"></i></a>
            <a href="#" class="text-decoration-none text-muted"><i class="fas fa-sort-amount-down"></i></a>
        </div>
    </div>

    <div class="row" id="propertyContainer">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-12 mb-4">
                <div class="card property-card row g-0 flex-md-row">
                    
                    <div class="col-md-5 col-12 bg-light">
                        <img
                            src="images/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="<?php echo htmlspecialchars($row['name']); ?>"
                        >
                    </div>

                    <div class="col-md-7 col-12 card-body p-4 d-flex flex-column justify-content-between">
                        
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="rating-stars">
                                    <?php 
                                    $stars = floor($row['rating']);
                                    for($i = 0; $i < 5; $i++) {
                                        echo $i < $stars ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                    <span class="text-muted fw-bold ms-1"><?php echo $row['rating']; ?></span>
                                </div>
                                <div class="interested-text">
                                    <i class="fas fa-heart text-danger"></i> <span>3 interested</span>
                                </div>
                            </div>

                            <h3 class="card-title fw-bold mb-1" style="color: #2d2d2d; font-size: 1.4rem;">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h3>
                            
                            <p class="text-muted small mb-3">
                                <i class="fas fa-map-marker-alt text-secondary me-1"></i> 
                                <?php echo htmlspecialchars($row['city']); ?> City Area Listing
                            </p>

                            <div class="mb-2">
                                <?php if(strtolower($row['gender']) == 'girls' || strtolower($row['gender']) == 'female'): ?>
                                    <span class="gender-badge-girls"><i class="fas fa-female me-1"></i> Girls Only</span>
                                <?php else: ?>
                                    <span class="gender-badge-boys"><i class="fas fa-male me-1"></i> Boys Only</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center card-footer-row">
                            <div>
                                <span class="price-amount">₹<?php echo number_format($row['price']); ?>/-</span>
                                <span class="text-muted small d-block d-sm-inline">per month</span>
                            </div>
                            
                            <a href="property_details.php?id=<?php echo $row['id']; ?>" class="btn btn-view-details text-uppercase btn-sm shadow-sm rounded">
                                View Details
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        <?php } ?>

    </div>

</div>

<script>
const cityFilter = document.getElementById("cityFilter");
const genderFilter = document.getElementById("genderFilter");
const budgetFilter = document.getElementById("budgetFilter");
const propertyContainer = document.getElementById("propertyContainer");

function filterProperties() {
    const city = cityFilter.value;
    const gender = genderFilter.value;
    const budget = budgetFilter.value;

    propertyContainer.innerHTML = '<div class="text-center py-4"><h5>Loading...</h5></div>';

    fetch(
        "filter_properties.php?city=" +
        encodeURIComponent(city) +
        "&gender=" +
        encodeURIComponent(gender) +
        "&budget=" +
        encodeURIComponent(budget)
    )
    .then(response => response.text())
    .then(data => {
        propertyContainer.innerHTML = data;
    })
    .catch(error => {
        propertyContainer.innerHTML = '<div class="alert alert-danger">Error loading properties.</div>';
        console.error(error);
    });
}

cityFilter.addEventListener("change", filterProperties);
genderFilter.addEventListener("change", filterProperties);
budgetFilter.addEventListener("input", filterProperties);
</script>

</body>
</html>
