<?php
include "connect.php";

$error = "";

if (isset($_POST['create'])) {
    $business_name = isset($_POST['business_name']) ? trim($_POST['business_name']) : "";
    $date_of_registration = isset($_POST['date_of_registration']) ? trim($_POST['date_of_registration']) : "";
    $business_total_assets = isset($_POST['business_total_assets']) ? trim($_POST['business_total_assets']) : "";

    if ($business_name === "" || $date_of_registration === "" || $business_total_assets === "") {
        $error = "All fields are required.";
    } elseif (!is_numeric($business_total_assets) || (float)$business_total_assets < 0) {
        $error = "Total asset must be a valid amount.";
    } else {
        $assets = (float)$business_total_assets;
        $category = "";

        if ($assets <= 3000000) {
            $category = "Micro";
        } elseif ($assets <= 15000000) {
            $category = "Small";
        } elseif ($assets <= 100000000) {
            $category = "Medium";
        } else {
            $category = "Large";
        }

        $query = "INSERT INTO business (business_name, date_of_registration, business_total_assets, business_category)
                  VALUES ('$business_name', '$date_of_registration', '$assets', '$category')";

        if ($conn->query($query)) {
            header("Location: index.php");
            exit;
        }

        $error = "Unable to save business.";
    }
}
?>

<form action="create.php" method="POST">
    Business Name: <input type="text" name="business_name" value="<?= isset($_POST['business_name']) ? htmlspecialchars($_POST['business_name']) : '' ?>" required><br>
    Date of Registration: <input type="date" name="date_of_registration" value="<?= isset($_POST['date_of_registration']) ? htmlspecialchars($_POST['date_of_registration']) : '' ?>" required><br>
    Total Asset: <input type="number" step="0.01" min="0" name="business_total_assets" value="<?= isset($_POST['business_total_assets']) ? htmlspecialchars($_POST['business_total_assets']) : '' ?>" required><br>
    <button type="submit" name="create">Save Business</button>
</form>

<?php if ($error): ?>
    <br>
    <?= htmlspecialchars($error) ?>
<?php endif; ?>

<br><br>
<a href="index.php">Back</a>
