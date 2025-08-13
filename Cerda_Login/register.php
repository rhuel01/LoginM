<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$first_name     = trim($_POST['first-name'] ?? '');
$middle_initial = trim($_POST['middle-initial'] ?? '');
$last_name      = trim($_POST['last-name'] ?? '');
$email          = trim($_POST['email'] ?? '');
$username       = trim($_POST['signup-username'] ?? '');
$password_raw   = $_POST['signup-password'] ?? '';

if (!$first_name || !$middle_initial || !$last_name || !$email || !$username || !$password_raw) {
    header('Location: index.php?error=Please fill in all fields.');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?error=Invalid email format.');
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
$stmt->execute([$email, $username]);
if ($stmt->fetch()) {
    header('Location: index.php?error=Username or email already exists.');
    exit;
}

$hash = password_hash($password_raw, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('
    INSERT INTO users (first_name, middle_initial, last_name, email, username, password_hash)
    VALUES (?, ?, ?, ?, ?, ?)
');
$stmt->execute([$first_name, $middle_initial, $last_name, $email, $username, $hash]);

header('Location: index.php?success=Registration successful! Please login.');
exit;