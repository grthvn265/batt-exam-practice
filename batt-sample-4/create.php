<?php
include "connect.php";

if (isset($_POST['create'])) {
    $family_name = trim($_POST['family_name']);
    $given_name = trim($_POST['given_name']);
    $middle_name = trim($_POST['middle_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_residency = $_POST['date_of_residency'];
    $property_land_area = (float) $_POST['property_land_area'];

    $part1 = strtoupper(substr($family_name, 0, 3));
    $part2 = strtoupper(date('dMY', strtotime($date_of_birth)));
    $part3 = date('Y', strtotime($date_of_residency));
    $part4 = str_pad((string) rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $resident_id = $part1 . '-' . $part2 . '-' . $part3 . '-' . $part4;

    $insert = "INSERT INTO residents (resident_id, family_name, given_name, middle_name, date_of_birth, date_of_residency, property_land_area)
               VALUES ('$resident_id', '$family_name', '$given_name', '$middle_name', '$date_of_birth', '$date_of_residency', '$property_land_area')";

    if ($conn->query($insert)) {
        header('Location: index.php');
        exit;
    }
}
?>

<a href="index.php">Back</a>
<h3>Add Resident</h3>

<form method="POST" action="create.php">
    Family Name: <input type="text" name="family_name" required><br>
    Given Name: <input type="text" name="given_name" required><br>
    Middle Name: <input type="text" name="middle_name" required><br>
    Date of Birth: <input type="date" name="date_of_birth" required><br>
    Date of Residency: <input type="date" name="date_of_residency" required><br>
    Property Land Area (sqm): <input type="number" step="0.01" name="property_land_area" required><br>
    <button type="submit" name="create">Save</button>
</form>
