<?php
// $servername = "184.168.102.208";
// $username = "admin"; // default username for localhost is root
// $password = "admin123"; // default password for localhost is empty
// $dbname = "userform"; // database name

$servername = "localhost";
$username = "root"; // default username for localhost is root
$password = ""; // default password for localhost is empty
$dbname = "userform"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>