<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT p.*
          FROM properties p
          JOIN interested_users i
          ON p.id = i.property_id
          WHERE i.user_id = $user_id";

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
    <title>My Shortlist - PG Life</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .property-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .property-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>My Shortlisted Properties ❤️</h2>

        <a href="properties.php" class="btn btn-secondary">
            Back to Properties
        </a>

    </div>

    <div class="row">

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="col-12 mb-4">

                    <div class="card property-card">

                        <img
                            src="images/<?php echo $row['image']; ?>"
                            alt="<?php echo $row['name']; ?>"
                        >

                        <div class="card-body">

                            <h3><?php echo $row['name']; ?></h3>

                            <p><strong>City:</strong> <?php echo $row['city']; ?></p>

                            <p><strong>Price:</strong> ₹<?php echo $row['price']; ?>/month</p>

                            <p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>

                            <p><strong>Rating:</strong> ⭐ <?php echo $row['rating']; ?></p>

                            <a href="property_details.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-primary">
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="alert alert-info">
                You haven't shortlisted any properties yet.
            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>