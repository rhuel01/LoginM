<?php
session_start();
require 'connect.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token   = $_POST['token'] ?? '';
    $newpass = $_POST['new-password'] ?? '';

    if (strlen($newpass) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters.";
        header("Location: forget_reset.php?token=" . urlencode($token));
        exit;
    }

    // Validate token
    $stmt = $pdo->prepare("SELECT user_id, expires_at FROM reset_tokens WHERE token = ?");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if ($row && new DateTime() < new DateTime($row['expires_at'])) {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);

        $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
            ->execute([$hash, $row['user_id']]);

        $pdo->prepare("DELETE FROM reset_tokens WHERE token = ?")->execute([$token]);

        $_SESSION['message'] = "Password reset. Please log in.";
        header("Location: index.php?success=Password reset. Please log in.");
        exit;
    } else {
        $_SESSION['error'] = "Invalid or expired reset token.";
        header("Location: forget_reset.php?token=" . urlencode($token));
        exit;
    }
}

if (!$token) {
    $_SESSION['error'] = "No reset token provided.";
    header("Location: index.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <div class="login-box">
      <h2>Reset Password</h2>
      <?php if ($error): ?>
        <p style="color:#ffb4b4; margin-bottom:10px;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="POST" action="forget_reset.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="input-box">
          <input type="password" name="new-password" required>
          <label>New Password</label>
        </div>
        <button type="submit" class="btn">Update Password</button>
        <div class="signup-link" style="margin-top:16px;">
          <a href="index.php">Back to Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>