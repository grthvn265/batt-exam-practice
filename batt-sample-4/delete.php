<?php
include "connect.php";

if (!isset($_POST['delete'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_POST['id'];
$query = "DELETE FROM residents WHERE id = '$id'";

if ($conn->query($query)) {
    header('Location: index.php');
    exit;
}
