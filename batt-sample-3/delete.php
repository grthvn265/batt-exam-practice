<?php
include "db.php"; 
if(isset($_POST['delete'])) {

    $id = $_POST['id'];
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