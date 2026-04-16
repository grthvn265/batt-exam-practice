<?php
include "connect.php";

if (!isset($_POST['update'])) {
    header("Location: index.php");
    exit;
}

$id = trim($_POST['id'] ?? "");
$business_name = trim($_POST['business_name'] ?? "");
$date_of_registration = trim($_POST['date_of_registration'] ?? "");
$business_total_assets = trim($_POST['business_total_assets'] ?? "");

if (!is_numeric($id) || (int)$id < 1) {
    header("Location: index.php");
    exit;
}

if ($business_name === "" || $date_of_registration === "" || $business_total_assets === "") {
    echo "All fields are required.";
    exit;
}

if (!is_numeric($business_total_assets) || (float)$business_total_assets < 0) {
    echo "Total asset must be a valid amount.";
    exit;
}

$id = (int)$id;
$assets = (float)$business_total_assets;
$category = $assets <= 3000000 ? "Micro" : ($assets <= 15000000 ? "Small" : ($assets <= 100000000 ? "Medium" : "Large"));

$query = "UPDATE business SET
    business_name = '$business_name',
    date_of_registration = '$date_of_registration',
    business_total_assets = '$assets',
    business_category = '$category'
    WHERE id = '$id'";

if ($conn->query($query)) {
    header("Location: index.php");
    exit;
}

echo "Unable to update record.";
?>
