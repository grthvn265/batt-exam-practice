<?php
include "connect.php";

$search = "";
$cedula_search = "";
$cedula_record = null;
$cedula_amount = null;
$cedula_error = "";

if (isset($_POST['compute_cedula']) && strlen($_POST['resident_num']) > 0) {
    $cedula_search = trim(htmlspecialchars(strip_tags($_POST['resident_num'])));
    $cedula_query = "SELECT resident_num, last_name, first_name, res_type, annual_income FROM residents WHERE resident_num = '$cedula_search'";
    $cedula_result = mysqli_query($conn, $cedula_query);

    if ($cedula_result && mysqli_num_rows($cedula_result) > 0) {
        $cedula_record = mysqli_fetch_assoc($cedula_result);
        $basic_tax = 5;
        $income_tax = floor($cedula_record['annual_income'] / 1000);
        $tenant_fee = $cedula_record['res_type'] == 'Tenant' ? 25 : 0;
        $cedula_amount = $basic_tax + $income_tax + $tenant_fee;
    } else {
        $cedula_error = "Resident number not found.";
    }
}

if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
    $search = trim(htmlspecialchars(strip_tags($_GET['search'])));
    $query = "SELECT * FROM residents WHERE resident_num LIKE '%$search%' OR last_name LIKE '%$search%'";
} else {
    $query = "SELECT * FROM residents";
}
$result = mysqli_query($conn, $query);
?>

<a href="create.php">Add Resident</a>
<br><br>

<form action="index.php" method="GET">
    <input type="text" name="search" value="<?= $search ?>" placeholder="Search ID or Name...">
    <button type="submit">Search</button>
</form>

<br>

<form action="index.php" method="POST">
    <input type="text" name="resident_num" value="<?= $cedula_search ?>" placeholder="Resident Number" required>
    <button type="submit" name="compute_cedula">Compute Cedula</button>
</form>

<?php if ($cedula_record): ?>
    <br>
    Resident Number: <?= $cedula_record['resident_num'] ?><br>
    Resident Name: <?= $cedula_record['last_name'] . ", " . $cedula_record['first_name'] ?><br>
    Resident Type: <?= $cedula_record['res_type'] ?><br>
    Gross Annual Income: Php <?= number_format($cedula_record['annual_income'], 2) ?><br>
    Community Tax Certificate: Php <?= number_format($cedula_amount, 2) ?><br>
<?php endif; ?>

<?php if ($cedula_error): ?>
    <br>
    <?= $cedula_error ?><br>
<?php endif; ?>

<br>

<table border="1">
    <thead>
        <tr>
            <th>Resident Number</th>
            <th>Name</th>
            <th>Type</th>
            <th>Annual Income</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['resident_num'] ?></td>
                    <td><?= $row['last_name'] . ", " . $row['first_name'] ?></td>
                    <td><?= $row['res_type'] ?></td>
                    <td><?= $row['annual_income'] ?></td>
                    <td>
                        <form action="edit.php" method="POST" style="display:inline">
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

