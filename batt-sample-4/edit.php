<?php
include "connect.php";

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $resident_id = trim($_POST['resident_id']);
    $family_name = trim($_POST['family_name']);
    $given_name = trim($_POST['given_name']);
    $middle_name = trim($_POST['middle_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_residency = $_POST['date_of_residency'];
    $property_land_area = (float) $_POST['property_land_area'];

    $update = "UPDATE residents
               SET resident_id = '$resident_id',
                   family_name = '$family_name',
                   given_name = '$given_name',
                   middle_name = '$middle_name',
                   date_of_birth = '$date_of_birth',
                   date_of_residency = '$date_of_residency',
                   property_land_area = '$property_land_area'
               WHERE id = '$id'";

    if ($conn->query($update)) {
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
} else {
    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM residents WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header('Location: index.php');
    exit;
}
?>

<a href="index.php">Back</a>
<h3>Edit Resident</h3>

<form method="POST" action="edit.php">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    Resident ID: <input type="text" name="resident_id" value="<?= htmlspecialchars($row['resident_id']) ?>" required><br>
    Family Name: <input type="text" name="family_name" value="<?= htmlspecialchars($row['family_name']) ?>" required><br>
    Given Name: <input type="text" name="given_name" value="<?= htmlspecialchars($row['given_name']) ?>" required><br>
    Middle Name: <input type="text" name="middle_name" value="<?= htmlspecialchars($row['middle_name']) ?>" required><br>
    Date of Birth: <input type="date" name="date_of_birth" value="<?= htmlspecialchars($row['date_of_birth']) ?>" required><br>
    Date of Residency: <input type="date" name="date_of_residency" value="<?= htmlspecialchars($row['date_of_residency']) ?>" required><br>
    Property Land Area (sqm): <input type="number" step="0.01" name="property_land_area" value="<?= htmlspecialchars($row['property_land_area']) ?>" required><br>

    <button type="submit" name="update">Update</button>
</form>
