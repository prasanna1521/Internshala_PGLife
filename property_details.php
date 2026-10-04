<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

$id = $_GET['id'];

$query = "SELECT * FROM properties WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$property = mysqli_fetch_assoc($result);

if (!$property) {
    die("Property not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $property['name']; ?> - PG Life</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .property-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <a href="properties.php" class="btn btn-secondary mb-4">
        ← Back to Properties
    </a>

    <div class="card">

        <img
            src="images/<?php echo $property['image']; ?>"
            class="property-image"
            alt="<?php echo $property['name']; ?>"
        >

        <div class="card-body">

            <h1><?php echo $property['name']; ?></h1>

            <hr>

            <p><strong>City:</strong> <?php echo $property['city']; ?></p>

            <p><strong>Rent:</strong> ₹<?php echo $property['price']; ?>/month</p>

            <p><strong>Gender:</strong> <?php echo $property['gender']; ?></p>

            <p><strong>Rating:</strong> ⭐ <?php echo $property['rating']; ?></p>

            <p><strong>Description:</strong></p>

            <p><?php echo $property['description']; ?></p>

            <button
                id="interest-btn"
                class="btn btn-success"
                data-id="<?php echo $property['id']; ?>">
                I'm Interested ❤️
            </button>

        </div>

    </div>

</div>

<script>
document.getElementById("interest-btn").addEventListener("click", function() {

    let propertyId = this.getAttribute("data-id");

    fetch("toggle_interest.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "property_id=" + propertyId
    })
    .then(response => response.text())
    .then(data => {

        if (data === "login_required") {

            alert("Please login first!");
            window.location.href = "login.php";

        } else if (data === "added") {

            alert("Property added to your shortlist ❤️");

        } else if (data === "removed") {

            alert("Property removed from your shortlist");

        }
    });

});
</script>

</body>
</html>