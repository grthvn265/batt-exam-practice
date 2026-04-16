<?php
include "connect.php";

if (!isset($_POST['update'])) {
	header("Location: index.php");
	exit;
}

$id = $_POST['id'];
$ln = $_POST['last_name'];
$fn = $_POST['first_name'];
$mn = $_POST['middle_name'];
$dob = $_POST['dob'];
$h_num = $_POST['house_num'];
$street = $_POST['street'];
$zip = $_POST['zip'];
$income = $_POST['income'];
$type = $_POST['res_type'];

$part1 = strtoupper(substr($ln, 0, 3));
$part2 = $h_num;
$part3 = strtoupper(substr($street, 0, 3));
$part4 = $zip;
$part5 = strtoupper(date("dMY", strtotime($dob)));

$res_num = $part1 . "-" . $part2 . $part3 . $part4 . "-" . $part5;

$query = "UPDATE residents SET
	resident_num = '$res_num',
	last_name = '$ln',
	first_name = '$fn',
	middle_name = '$mn',
	birth_date = '$dob',
	house_num = '$h_num',
	street_name = '$street',
	zip_code = '$zip',
	res_type = '$type',
	annual_income = '$income'
	WHERE id = '$id'";

if ($conn->query($query)) {
	header("Location: index.php");
	exit;
}

echo "Unable to update record.";
?>