<?php

$conn = new mysqli ('localhost', 'root', '', 'pse3');   

if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

