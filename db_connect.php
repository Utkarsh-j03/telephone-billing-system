<?php
$servername = "localhost";
$username = "username"; //enter username
$password = "password"; //enter password
$dbname = "telephone_billing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>