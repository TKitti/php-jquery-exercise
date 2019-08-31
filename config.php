<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_DATABASE');

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error());
}
?>