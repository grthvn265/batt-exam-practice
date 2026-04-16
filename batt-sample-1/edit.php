<?php
include "connect.php";

if (!isset($_POST['edit']) || !isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];
$query = "SELECT * FROM residents WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: index.php");
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    Resident Number: <input type="text" value="<?= $row['resident_num'] ?>" readonly><br>
    Last Name: <input type="text" name="last_name" value="<?= $row['last_name'] ?>" required><br>
    First Name: <input type="text" name="first_name" value="<?= $row['first_name'] ?>" required><br>
    Middle Name: <input type="text" name="middle_name" value="<?= $row['middle_name'] ?>"><br>
    DOB: <input type="date" name="dob" value="<?= $row['birth_date'] ?>" required><br>
    House #: <input type="text" name="house_num" value="<?= $row['house_num'] ?>" required><br>
    Street: <input type="text" name="street" value="<?= $row['street_name'] ?>" required><br>
    Zip Code: <input type="text" name="zip" value="<?= $row['zip_code'] ?>" required><br>
    Income: <input type="number" step="0.01" name="income" value="<?= $row['annual_income'] ?>" required><br>
    Type: <select name="res_type">
        <option value="Homeowner" <?= $row['res_type'] == 'Homeowner' ? 'selected' : '' ?>>Homeowner</option>
        <option value="Tenant" <?= $row['res_type'] == 'Tenant' ? 'selected' : '' ?>>Tenant</option>
    </select><br>
    <button type="submit" name="update">Update Resident</button>
</form>

<br>

<a href="index.php">Back</a>