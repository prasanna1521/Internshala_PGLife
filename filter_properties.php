<?php
include("db.php");

$city = $_GET['city'];
$gender = $_GET['gender'];
$budget = $_GET['budget'];

$query = "SELECT * FROM properties WHERE 1=1";

if (!empty($city)) {
    $query .= " AND city = '$city'";
}

if (!empty($gender)) {
    $query .= " AND gender = '$gender'";
}

if (!empty($budget)) {
    $query .= " AND price <= $budget";
}

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
?>

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

            <a
                href="property_details.php?id=<?php echo $row['id']; ?>"
                class="btn btn-success">
                View Details
            </a>

        </div>

    </div>

</div>

<?php } ?>