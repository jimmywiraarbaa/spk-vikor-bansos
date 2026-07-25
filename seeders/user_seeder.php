<?php
require_once __DIR__ . '/../includes/db.php';

$users = [
    [
        'username' => 'admin',
        'email' => 'admin@spkvikor.test',
        'password' => 'admin123',
        'role' => 'admin',
        'nama_lengkap' => 'Administrator',
    ],
    [
        'username' => 'operator',
        'email' => 'operator@spkvikor.test',
        'password' => 'operator123',
        'role' => 'operator',
        'nama_lengkap' => 'Operator',
    ],
    [
        'username' => 'kepala_dinsos',
        'email' => 'kepala@spkvikor.test',
        'password' => 'kepala123',
        'role' => 'kepala_dinsos',
        'nama_lengkap' => 'Kepala Dinas Sosial',
    ],
];

$stmt = $pdo->prepare("INSERT IGNORE INTO users (username, email, password, role, nama_lengkap) VALUES (?, ?, ?, ?, ?)");

foreach ($users as $user) {
    $hashed = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt->execute([$user['username'], $user['email'], $hashed, $user['role'], $user['nama_lengkap']]);
    echo "User '{$user['username']}' berhasil ditambahkan.\n";
}
