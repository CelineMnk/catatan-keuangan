<?php
$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare data
$name = 'Iel Manik';
$email = 'ielmanik038@gmail.com';
// bcrypt hash for 'Celiinmaniik20' is not known here; use a known hash for 'password' OR generate using password_hash
$plain = 'Celiinmaniik20';
$hash = password_hash($plain, PASSWORD_BCRYPT);

try {
    $stmt = $db->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (:name, :email, :password, datetime('now'), datetime('now'))");
    $stmt->execute([':name' => $name, ':email' => $email, ':password' => $hash]);
    echo "Inserted user $email with password='$plain'\n";
} catch (PDOException $e) {
    echo "Error inserting user: " . $e->getMessage() . "\n";
}
