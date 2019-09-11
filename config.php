<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$db_name = getenv('DB_DATABASE');

$conn = mysqli_connect($host, $user, $password, $db_name);

if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error());
}
?>
