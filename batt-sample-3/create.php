<?php
include "db.php";

$last_name = "";
$first_name = "";
$middle_name = "";
$date_of_birth = "";
$date_of_stay = "";
$civil_status = "";
$res_code = "";
$error = "";

if(isset($_POST['submit'])) {
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ""));
    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ""));
    $middle_name = htmlspecialchars(trim($_POST['middle_name'] ?? ""));
    $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth'] ?? ""));
    $date_of_stay = htmlspecialchars(trim($_POST['date_of_stay'] ?? ""));
    $civil_status = htmlspecialchars(trim($_POST['civil_status'] ?? ""));

    $allowed_status = ["Single", "Married", "Seperated", "Separated", "Widowed", "Divorced"];

    if ($last_name === "" || $first_name === "" || $date_of_birth === "" || $date_of_stay === "" || $civil_status === "") {
        $error = "Please fill in all required fields.";
    } elseif (!in_array($civil_status, $allowed_status, true)) {
        $error = "Invalid civil status.";
    } elseif (!strtotime($date_of_birth) || !strtotime($date_of_stay)) {
        $error = "Invalid date value.";
    } elseif (strtotime($date_of_stay) < strtotime($date_of_birth)) {
        $error = "Date of stay cannot be earlier than date of birth.";
    } else {
        $safe_last_name = mysqli_real_escape_string($conn, $last_name);
        $safe_first_name = mysqli_real_escape_string($conn, $first_name);
        $safe_middle_name = mysqli_real_escape_string($conn, $middle_name);
        $safe_date_of_birth = mysqli_real_escape_string($conn, $date_of_birth);
        $safe_date_of_stay = mysqli_real_escape_string($conn, $date_of_stay);
        $safe_civil_status = mysqli_real_escape_string($conn, $civil_status);

        $part1 = strtoupper(substr($last_name, 0, 3));
        $part2 = strtoupper(date('mdY', strtotime($date_of_birth)));
        $part3 = strtoupper(substr($civil_status, 0, 1));
        $part4 = str_pad(rand(0, 9999), 5, '0', STR_PAD_LEFT);
        $res_code = $part1 . "-" . $part2 . "-" . $part3 . "-" . $part4;

        $query = "INSERT INTO residents (resident_code, last_name, given_name, middle_name, date_of_birth, date_of_stay, civil_status)
         VALUES ('$res_code', '$safe_last_name', '$safe_first_name', '$safe_middle_name', '$safe_date_of_birth', '$safe_date_of_stay', '$safe_civil_status')";

        if ($conn->query($query)) {
            header("Location: index.php");
            exit;
        }

        $error = "Unable to add resident.";
    }
}

?>

<h3>Add New Resident</h3>
<a href="index.php">Back</a>
<br>
<?php if ($error !== ""): ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
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



