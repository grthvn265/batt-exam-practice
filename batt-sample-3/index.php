<?php 
include "db.php";
$query = "SELECT * FROM residents";
$result = mysqli_query($conn, $query);

?>

<a href="create.php">Add Resident</a>
<br>
<a href="transaction.php">Transaction</a>
<br>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Resident Name</th>
            <th>Resident Code</th>
            <th>Date of Birth</th>
            <th>Date of Stay</th>
            <th>Civil Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['last_name'] . ", " . $row['given_name'] . " " . $row['middle_name']; ?></td>
                    <td><?php echo $row['resident_code']; ?></td>
                    <td><?php echo $row['date_of_birth']; ?></td>
                    <td><?php echo $row['date_of_stay']; ?></td>
                    <td><?php echo $row['civil_status']; ?></td>
                    <td>
                        <form action="edit.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                        <form action="delete.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>
