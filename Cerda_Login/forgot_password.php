<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forgot_password.php?error=Please enter a valid email address.");
        exit;
    }

    // If email exists, create token (do not reveal existence)
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $pdo->prepare('DELETE FROM reset_tokens WHERE user_id = ?')->execute([$user['id']]);
        $pdo->prepare('INSERT INTO reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)')
            ->execute([$user['id'], $token, $expires]);

        // In real app you would email this. For local dev we show the link:
        $_SESSION['reset_link'] = "http://localhost/your-folder/forget_reset.php?token=" . urlencode($token);
    }

    header("Location: forgot_password.php?success=If an account with this email exists, a reset link has been created.");
    exit;
}

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
$link    = $_SESSION['reset_link'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <div class="login-box">
      <h2>Forgot Password</h2>
      <?php if ($success): ?>
        <p style="color:#0ef; margin-bottom:10px;"><?= htmlspecialchars($success) ?></p>
        <?php if ($link): ?>
          <p style="color:#fff; font-size:0.9em;">Dev reset link: <a style="color:#0ef" href="<?= htmlspecialchars($link) ?>">Reset Password</a></p>
        <?php endif; ?>
      <?php endif; ?>
      <?php if ($error): ?>
        <p style="color:#ffb4b4; margin-bottom:10px;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="POST" action="forgot_password.php">
        <div class="input-box">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <button type="submit" class="btn">Send Reset Link</button>
        <div class="signup-link" style="margin-top:16px;">
          <a href="index.php">Back to Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>