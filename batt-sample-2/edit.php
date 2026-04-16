<?php
include "connect.php";

if (!isset($_POST['edit']) || !isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];
if (!is_numeric($id) || (int)$id < 1) {
    header("Location: index.php");
    exit;
}

$id = (int)$id;
$query = "SELECT * FROM business WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: index.php");
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    Business ID: <input type="text" value="<?= $row['id'] ?>" readonly><br>
    Business Name: <input type="text" name="business_name" value="<?= htmlspecialchars($row['business_name']) ?>" required><br>
    Date of Registration: <input type="date" name="date_of_registration" value="<?= $row['date_of_registration'] ?>" required><br>
    Total Asset: <input type="number" step="0.01" min="0" name="business_total_assets" value="<?= $row['business_total_assets'] ?>" required><br>
    <button type="submit" name="update">Update Business</button>
</form>

<br>
<a href="index.php">Back</a>
