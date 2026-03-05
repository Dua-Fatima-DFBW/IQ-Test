<?php
$host = 'localhost';
$dbname = 'rsoa_rsoa311_31';
$username = 'rsoa_rsoa311_31'; // Updated to match DB name pattern
$password = '123456';

// NOTE: If you are using XAMPP/WAMP (Localhost) and this fails, try:
// $username = 'root';
// $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
