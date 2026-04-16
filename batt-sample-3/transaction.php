<?php
include "db.php";

$resident_code = "";
$selected_documents = [];
$resident = null;
$amount_due = 0;
$error = "";

if (isset($_POST['apply_documents'])) {
	$resident_code = trim($_POST['resident_code'] ?? "");
	$selected_documents = $_POST['documents'] ?? [];

	if ($resident_code === "") {
		$error = "Resident code is required.";
	} else {
		$code = mysqli_real_escape_string($conn, $resident_code);
		$query = "SELECT * FROM residents WHERE resident_code = '$code'";
		$result = mysqli_query($conn, $query);

		if ($result && mysqli_num_rows($result) > 0) {
			$resident = mysqli_fetch_assoc($result);
		} else {
			$error = "Resident code not found.";
		}
	}

	if ($error === "" && empty($selected_documents)) {
		$error = "Please select at least one document.";
	}

	if ($error === "" && $resident) {
		$age = (new DateTime())->diff(new DateTime($resident['date_of_birth']))->y;
		$years_of_stay = (new DateTime())->diff(new DateTime($resident['date_of_stay']))->y;
		$system_month = (int) date('n');

		foreach ($selected_documents as $document) {
			$fee = 0;

			if ($document === 'Barangay Clearance') {
				if ($age < 18 || $age >= 60) {
					$fee = 0;
				} elseif ($age < 25) {
					$fee = 175.00;
				} else {
					$fee = 180.00;
				}
			} elseif ($document === 'Business Permit') {
				$fee = 325.00;
				if ($resident['civil_status'] === 'Single') {
					$fee = $fee + 125.00;
				}
			} elseif ($document === 'Certificate of Residency') {
				$fee = 200.00;
				if ($years_of_stay >= 10) {
					$fee = $fee + 50.00;
				} else {
					$fee = $fee + 100.00;
				}
			}

			if ($system_month >= 7 && $system_month <= 12 && $fee > 0) {
				$fee = $fee + 50.00;
			}

			$amount_due = $amount_due + $fee;
		}
	}
}
?>

<a href="index.php">Back</a>

<h3>Document Transaction</h3>

<form action="transaction.php" method="POST">
	Resident Code: <input type="text" name="resident_code" value="<?php echo htmlspecialchars($resident_code); ?>" required>
	<br><br>

	<label><input type="checkbox" name="documents[]" value="Barangay Clearance" <?php echo in_array('Barangay Clearance', $selected_documents) ? 'checked' : ''; ?>> Barangay Clearance</label><br>
	<label><input type="checkbox" name="documents[]" value="Business Permit" <?php echo in_array('Business Permit', $selected_documents) ? 'checked' : ''; ?>> Business Permit</label><br>
	<label><input type="checkbox" name="documents[]" value="Certificate of Residency" <?php echo in_array('Certificate of Residency', $selected_documents) ? 'checked' : ''; ?>> Certificate of Residency</label><br><br>

	<button type="submit" name="apply_documents">Apply Documents</button>
</form>

<br>

<?php if ($error): ?>
	<p><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if ($resident): ?>
	<p>Resident: <?php echo htmlspecialchars($resident['last_name'] . ", " . $resident['given_name'] . " " . $resident['middle_name']); ?></p>
	<p>Resident Code: <?php echo htmlspecialchars($resident['resident_code']); ?></p>
	<p>Documents:</p>
	<ul>
		<?php foreach ($selected_documents as $document): ?>
			<li><?php echo htmlspecialchars($document); ?></li>
		<?php endforeach; ?>
	</ul>
	<p><strong>Amount Due: Php <?php echo number_format((float) $amount_due, 2); ?></strong></p>
<?php endif; ?>