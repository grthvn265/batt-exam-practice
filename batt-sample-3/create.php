<?php
include "db.php";

$last_name = "";
$first_name = "";
$middle_name = "";
$date_of_birth = "";
$date_of_stay = "";
$civil_status = "";
$res_code = "";

if(isset($_POST['submit'])) {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_stay = $_POST['date_of_stay'];
    $civil_status = $_POST['civil_status'];

    $part1 = strtoupper(substr($last_name, 0, 3));
    $part2 = strtoupper(date('mdY', strtotime($date_of_birth)));
    $part3 = strtoupper(substr($civil_status, 0, 1));
    $part4 = str_pad(rand(0, 9999), 5, '0', STR_PAD_LEFT);
    $res_code = $part1 . "-" . $part2 . "-" . $part3 . "-" . $part4;

    $query = "INSERT INTO residents (resident_code, last_name, given_name, middle_name, date_of_birth, date_of_stay, civil_status)
     VALUES ('$res_code', '$last_name', '$first_name', '$middle_name', '$date_of_birth', '$date_of_stay', '$civil_status')";

    if ($conn->query($query)) {
        header("Location: index.php");
        exit;
    }
}

?>

<h3>Add New Resident</h3>
<a href="index.php">Back</a>
<br>
<form action="create.php" method="POST" style="padding: 10px; margin: 5px;">
    Last Name<input type="text" name="last_name" placeholder="Last Name" required><br>
    First Name<input type="text" name="first_name" placeholder="First Name" required><br>
    Middle Name<input type="text" name="middle_name" placeholder="Middle Name"><br>
    Date of Birth<input type="date" name="date_of_birth" placeholder="Date of Birth" required><br>
    Date of Stay<input type="date" name="date_of_stay" placeholder="Date of Stay" required><br>
    Civil Status<select name="civil_status" required>
        <option value="">Select Civil Status</option>
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Seperated">Separated</option>
        <option value="Widowed">Widowed</option>
        <option value="Divorced">Divorced</option>
    </select><br>
    <button type="submit" name="submit">Submit</button>

    <?php if (isset($_POST['submit'])): ?>
        echo "Resident added successfully.";
    <?php endif; ?>
</form>



