<?php
session_start();
$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circular Animated Login & Sign-Up Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if ($success): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Login Container -->
    <div class="container" id="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form id="login-form" method="POST" action="login.php">
                <div class="input-box">
                    <input id="login-username" type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <input id="login-password" type="password" name="password" required>
                    <label>Password</label>
                </div>

                <!-- Options Row -->
                <div class="options-row">
                    <div class="forgot-password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    <div class="show-password">
                        <input type="checkbox" id="login-showpass">
                        <label for="login-showpass">Show Password</label>
                    </div>
                </div>

                <button type="submit" class="btn">Login</button>
                <div class="signup-link">
                    <p>Don't have an account? <a href="#" id="go-to-signup">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Sign-Up Container -->
    <div class="container hidden" id="signup-container">
        <div class="login-box">
            <h2>Sign Up</h2>
            <form id="signup-form" method="POST" action="register.php">
                <div class="input-box">
                    <input id="first-name" type="text" name="first-name" required>
                    <label>First Name</label>
                </div>
                <div class="input-box">
                    <input id="middle-initial" type="text" name="middle-initial" required>
                    <label>Middle Initial</label>
                </div>
                <div class="input-box">
                    <input id="last-name" type="text" name="last-name" required>
                    <label>Last Name</label>
                </div>
                <div class="input-box">
                    <input id="email" type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input id="signup-username" type="text" name="signup-username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <input id="signup-password" type="password" name="signup-password" required>
                    <label>Password</label>
                </div>



                <button type="submit" class="btn">Create Account</button>
                <div class="signup-link">
                    <p>Already have an account? <a href="#" id="go-to-login">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Welcome Screen -->
    <div id="welcome-screen" class="welcome-screen hidden">
        <div>
            <h2>Welcome! You have successfully logged in.</h2>
            <button id="logout-btn" class="btn" style="margin-top: 20px;">Logout</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Show/Hide password for Login
        document.getElementById("login-showpass").addEventListener("change", function() {
            const passInput = document.getElementById("login-password");
            passInput.type = this.checked ? "text" : "password";
        });

        // Show/Hide password for Sign-Up
        document.getElementById("signup-showpass").addEventListener("change", function() {
            const passInput = document.getElementById("signup-password");
            passInput.type = this.checked ? "text" : "password";
        });
    </script>
</body>
</html>
