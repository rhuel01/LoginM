<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=Please login first.");
    exit;
}

$firstName = htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <div class="container">
    <div class="login-box">
      <h2>Welcome, <?= $firstName ?>!</h2>
      <p style="color: white; margin: 15px 0;">You are logged in.</p>
      <button onclick="location.href='logout.php'" class="btn">Logout</button>
    </div>
  </div>

</body>
</html>
