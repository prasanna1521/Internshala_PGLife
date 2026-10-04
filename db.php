<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "pglife"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>