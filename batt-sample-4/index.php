<?php
include "connect.php";

$search = "";

if (isset($_GET['search']) && strlen(trim($_GET['search'])) > 0) {
	$search = trim($_GET['search']);
	$query = "SELECT * FROM residents
			  WHERE resident_id LIKE '%$search%'
				 OR family_name LIKE '%$search%'
				 OR given_name LIKE '%$search%'
			  ORDER BY id DESC";
} else {
	$query = "SELECT * FROM residents ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>

<a href="create.php">Add Resident</a>
<br>
<a href="transaction.php">Transaction</a>
<br><br>

<form method="GET" action="index.php">
	<input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search resident ID or name">
	<button type="submit">Search</button>
</form>

<br>

<table border="1" cellpadding="6" cellspacing="0">
	<thead>
		<tr>
			<th>Resident ID</th>
			<th>Resident Name</th>
			<th>Date of Birth</th>
			<th>Date of Residency</th>
			<th>Property Land Area</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($result): ?>
			<?php while ($row = mysqli_fetch_assoc($result)): ?>
				<tr>
					<td><?= htmlspecialchars($row['resident_id']) ?></td>
					<td><?= htmlspecialchars($row['family_name'] . ', ' . $row['given_name'] . ' ' . $row['middle_name']) ?></td>
					<td><?= htmlspecialchars(date('F j, Y', strtotime($row['date_of_birth']))) ?></td>
					<td><?= htmlspecialchars(date('F j, Y', strtotime($row['date_of_residency']))) ?></td>
					<td><?= number_format((float) $row['property_land_area'], 2) ?></td>
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
