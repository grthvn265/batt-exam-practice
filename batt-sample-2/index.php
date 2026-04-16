<?php
include "connect.php";

$search = "";
$business_record = null;
$business_id_input = "";
$gross_sales = "";
$amount_due = null;
$error = "";

if (isset($_GET['search']) && strlen(trim($_GET['search'])) > 0) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM business WHERE id LIKE '%$search%' OR business_name LIKE '%$search%' ORDER BY id ASC";
} else {
    $query = "SELECT * FROM business ORDER BY id ASC";
}

$result = mysqli_query($conn, $query);

if (isset($_POST['compute_tax'])) {
    $business_id = isset($_POST['business_id']) ? trim($_POST['business_id']) : "";
    $business_id_input = $business_id;
    $gross_sales = isset($_POST['gross_sales']) ? trim($_POST['gross_sales']) : "";

    if ($business_id === "" || $gross_sales === "") {
        $error = "Business ID and Gross Sales are required.";
    } elseif (!is_numeric($business_id) || (int)$business_id < 1) {
        $error = "Business ID must be a valid number.";
    } elseif (!is_numeric($gross_sales) || (float)$gross_sales < 0) {
        $error = "Gross Sales must be a valid amount.";
    } else {
        $id = (int)$business_id;
        $sales = (float)$gross_sales;

        $business_query = "SELECT * FROM business WHERE id = '$id'";
        $business_result = mysqli_query($conn, $business_query);

        if (!$business_result || mysqli_num_rows($business_result) === 0) {
            $error = "Business ID not found.";
        } else {
            $business_record = mysqli_fetch_assoc($business_result);
            $category = $business_record['business_category'];

            $tax_rate = 0;
            if ($category == 'Micro') {
                $tax_rate = 0.01;
            } elseif ($category == 'Small') {
                $tax_rate = 0.0125;
            } elseif ($category == 'Medium') {
                $tax_rate = 0.015;
            } elseif ($category == 'Large') {
                $tax_rate = 0.0175;
            }

            $tax_amount = $sales * $tax_rate;
            $fixed_penalty = 5000;
            $monthly_penalty = 500;

            $months_unregistered = 0;
            $reg_year = (int)date('Y', strtotime($business_record['date_of_registration']));
            $current_year = (int)date('Y');
            $current_month = (int)date('n');

            if ($current_year > $reg_year || ($current_year == $reg_year && $current_month >= 2)) {
                $months_unregistered = (($current_year - $reg_year) * 12) + ($current_month - 2) + 1;
                if ($months_unregistered < 0) {
                    $months_unregistered = 0;
                }
            }

            $penalty_amount = 0;
            if ($months_unregistered > 0) {
                $penalty_amount = $fixed_penalty + ($monthly_penalty * $months_unregistered);
            }

            $amount_due = $tax_amount + $penalty_amount;
            if ($amount_due < 500) {
                $amount_due = 500;
            }
        }
    }
}
?>

<a href="create.php">Add Business</a>
<br><br>

<form action="index.php" method="GET">
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search ID or Business Name">
    <button type="submit">Search</button>
</form>

<br>

<form action="index.php" method="POST">
    Business ID: <input type="number" name="business_id" min="1" value="<?= htmlspecialchars($business_id_input) ?>" required>
    Gross Sales: <input type="number" step="0.01" name="gross_sales" min="0" value="<?= htmlspecialchars($gross_sales) ?>" required>
    <button type="submit" name="compute_tax">Compute Amount Due</button>
</form>

<?php if ($business_record): ?>
    <br>
    Business ID: <?= $business_record['id'] ?><br>
    Business Name: <?= htmlspecialchars($business_record['business_name']) ?><br>
    Date of Registration: <?= htmlspecialchars($business_record['date_of_registration']) ?><br>
    Total Asset: <?= number_format((float)$business_record['business_total_assets'], 2) ?><br>
    Category: <?= htmlspecialchars($business_record['business_category']) ?><br>
    Gross Sales: <?= number_format((float)$gross_sales, 2) ?><br>
    Amount Due: P <?= number_format($amount_due, 2) ?><br>
<?php endif; ?>

<?php if ($error): ?>
    <br>
    <?= htmlspecialchars($error) ?><br>
<?php endif; ?>

<br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Business ID</th>
            <th>Business Name</th>
            <th>Date of Registration</th>
            <th>Total Asset</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['business_name']) ?></td>
                    <td><?= htmlspecialchars($row['date_of_registration']) ?></td>
                    <td><?= number_format((float)$row['business_total_assets'], 2) ?></td>
                    <td><?= htmlspecialchars($row['business_category']) ?></td>
                    <td>
                        <form action="edit.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                        <form action="delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>