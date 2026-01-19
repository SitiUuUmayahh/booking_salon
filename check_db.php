<?php

// Simple database check without Laravel Eloquent complexity
$host = '127.0.0.1';
$db = 'salon_booking';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $stmt = $pdo->query("SELECT id, name, image FROM services LIMIT 8;");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total Services: " . count($services) . "\n\n";
    foreach ($services as $s) {
        echo "ID: {$s['id']}, Name: {$s['name']}, Image: {$s['image']}\n";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
