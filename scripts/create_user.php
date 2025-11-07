<?php

$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = 'ielmanik038@gmail.com';
$name = 'Iel Manik';
$passwordPlain = 'Celiinmaniik20';
$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT);
$now = (new DateTime())->format('Y-m-d H:i:s');

// Check if user exists
$st = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
$st->execute([':email' => $email]);
if ($st->fetchColumn() > 0) {
    echo "User already exists\n";
    exit(0);
}

$ins = $db->prepare('INSERT INTO users (name, email, password, created_at, updated_at) VALUES (:name, :email, :password, :created_at, :updated_at)');
$ins->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $passwordHash,
    ':created_at' => $now,
    ':updated_at' => $now,
]);

echo "User created: $email\n";
