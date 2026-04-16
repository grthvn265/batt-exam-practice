<?php
include "connect.php";

if (!isset($_POST['delete']) || !isset($_POST['id'])) {
	header("Location: index.php");
	exit;
}

$id = $_POST['id'];
if (!is_numeric($id) || (int)$id < 1) {
	header("Location: index.php");
	exit;
}

$id = (int)$id;
$query = "DELETE FROM business WHERE id = '$id'";

if ($conn->query($query)) {
	header("Location: index.php");
	exit;
}

echo "Unable to delete record.";
?>
