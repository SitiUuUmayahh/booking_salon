<?php

$host = '127.0.0.1';
$db = 'salon_booking';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    // Delete all existing services
    $pdo->exec("DELETE FROM services;");
    echo "Deleted existing services\n";
    
    // Reset auto-increment
    $pdo->exec("ALTER TABLE services AUTO_INCREMENT = 1;");
    echo "Reset auto-increment\n";
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
