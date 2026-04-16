<?php
// Establish connection using $conn 
$conn = new mysqli('localhost', 'root', '', 'barangay_db');

if (!$conn) {
    echo "Connection has failed."; 
    die(mysqli_error($conn)); 
}