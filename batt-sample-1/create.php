<?php
include "connect.php";

if (isset($_POST['register'])) {
    $ln = $_POST['last_name'];
    $fn = $_POST['first_name'];
    $mn = $_POST['middle_name'];
    $dob = $_POST['dob']; 
    $h_num = $_POST['house_num'];
    $street = $_POST['street'];
    $zip = $_POST['zip'];
    $income = $_POST['income'];
    $type = $_POST['res_type'];
    $part1 = strtoupper(substr($ln, 0, 3));
    $part2 = $h_num;
    $part3 = strtoupper(substr($street, 0, 3));
    $part4 = $zip;
    $part5 = strtoupper(date("dMY", strtotime($dob)));
    
    $res_num = $part1 . "-" . $part2 . $part3 . $part4 . "-" . $part5;

    $sql = "INSERT INTO residents (resident_num, last_name, first_name, middle_name, birth_date, house_num, street_name, zip_code, res_type, annual_income) 
            VALUES ('$res_num', '$ln', '$fn', '$mn', '$dob', '$h_num', '$street', '$zip', '$type', '$income')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    }
}
?>

<form method="POST">
    Last Name: <input type="text" name="last_name" required><br>
    First Name: <input type="text" name="first_name" required><br>
    Middle Name: <input type="text" name="middle_name"><br>
    DOB: <input type="date" name="dob" required><br>
    House #: <input type="text" name="house_num" required><br>
    Street: <input type="text" name="street" required><br>
    Zip Code: <input type="text" name="zip" required><br>
    Income: <input type="number" step="0.01" name="income" required><br>
    Type: <select name="res_type">
        <option value="Homeowner">Homeowner</option>
        <option value="Tenant">Tenant</option>
    </select><br>
    <button type="submit" name="register">Register Resident</button>
</form>