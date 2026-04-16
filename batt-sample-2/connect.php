<?php

$conn = new mysqli('localhost', 'root', '', 'pse2');

if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

