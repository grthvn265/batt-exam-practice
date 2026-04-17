<?php
include "db.php"; 
if(isset($_POST['delete'])) {

    $id = trim($_POST['id'] ?? "");

    if (!ctype_digit($id)) {
        echo "Invalid resident ID.";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);
    $query = "DELETE FROM residents WHERE id = '$id'"; 

    if ($conn->query($query)) {
        $conn->close(); 
        header("Location: index.php");
    } else {
        echo "Unable to delete record.";
        die();
    }
}
?>