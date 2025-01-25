<?php
$conn = mysqli_connect("localhost", "root", "", "messenger");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?> 