<?php
include "db.php";

if (!isset($_POST['edit']) || !isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];
$id = trim($id);

if (!ctype_digit($id)) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $id);
$query = "SELECT * FROM residents WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: index.php");
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<a href="index.php">Back</a>

<form action="edit.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Last Name<input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" placeholder="Last Name" required>
    First Name<input type="text" name="first_name" value="<?php echo $row['given_name']; ?>" placeholder="First Name" required>
    Middle Name<input type="text" name="middle_name" value="<?php echo $row['middle_name']; ?>" placeholder="Middle Name">
    Date of Birth<input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" placeholder="Date of Birth" required>
    Date of Stay<input type="date" name="date_of_stay" value="<?php echo $row['date_of_stay']; ?>" placeholder="Date of Stay" required>
    <select name="civil_status" required>
        <option value="">Select Civil Status</option>
        <option value="Single" <?php if ($row['civil_status'] == 'Single') echo 'selected'; ?>>Single</option>
        <option value="Married" <?php if ($row['civil_status'] == 'Married') echo 'selected'; ?>>Married</option>
        <option value="Separated" <?php if ($row['civil_status'] == 'Separated') echo 'selected'; ?>>Separated</option>
        <option value="Widowed" <?php if ($row['civil_status'] == 'Widowed') echo 'selected'; ?>>Widowed</option>
        <option value="Divorced" <?php if ($row['civil_status'] == 'Divorced') echo 'selected'; ?>>Divorced</option>
</form>