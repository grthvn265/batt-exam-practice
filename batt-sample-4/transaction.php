<?php
include "connect.php";

$resident_code = "";
$payment_date = "";
$resident = null;
$total_tax = null;
$error = "";

if (isset($_POST['compute_tax'])) {
    $resident_code = trim($_POST['resident_code'] ?? "");
    $payment_date = trim($_POST['payment_date'] ?? "");

    if ($resident_code === "" || $payment_date === "") {
        $error = "Resident ID and Date of Payment are required.";
    } else {
        $safe_code = mysqli_real_escape_string($conn, $resident_code);
        $query = "SELECT * FROM residents WHERE resident_id = '$safe_code'";
        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) === 0) {
            $error = "Resident ID not found.";
        } else {
            $resident = mysqli_fetch_assoc($result);

            $area = (float) $resident['property_land_area'];
            $first_area = $area > 100 ? 100 : $area;
            $next_area = $area > 100 ? ($area - 100) : 0;

            $birth_date = new DateTime($resident['date_of_birth']);
            $residency_date = new DateTime($resident['date_of_residency']);
            $pay_date = new DateTime($payment_date);

            $age = $birth_date->diff($pay_date)->y;
            $years_in_barangay = $residency_date->diff($pay_date)->y;

            $first_rate = ($age >= 60) ? 15 : 25;
            $first_part_tax = $first_area * $first_rate;
            $next_rate = ($years_in_barangay >= 10) ? 50 : 75;
            $next_part_tax = $next_area * $next_rate;

            $total_tax = $first_part_tax + $next_part_tax;
        }
    }
}
?>

<a href="index.php">Back</a>
<h3>Property Tax Transaction</h3>

<form method="POST" action="transaction.php">
    Resident ID: <input type="text" name="resident_code" value="<?= htmlspecialchars($resident_code) ?>" required>
    Date of Payment: <input type="date" name="payment_date" value="<?= htmlspecialchars($payment_date) ?>" required>
    <button type="submit" name="compute_tax">Compute Property Tax</button>
</form>

<?php if ($error): ?>
    <br>
    <?= htmlspecialchars($error) ?>
<?php endif; ?>

<?php if ($resident && $total_tax !== null): ?>
    <br><br>
    Resident ID: <?= htmlspecialchars($resident['resident_id']) ?><br>
    Resident Name: <?= htmlspecialchars($resident['family_name'] . ', ' . $resident['given_name'] . ' ' . $resident['middle_name']) ?><br>
    Date of Payment: <?= htmlspecialchars(date('F j, Y', strtotime($payment_date))) ?><br>
    Property Land Area: <?= number_format((float) $resident['property_land_area'], 2) ?> sqm<br>
    Total Barangay Property Tax: Php <?= number_format((float) $total_tax, 2) ?><br>
<?php endif; ?>
