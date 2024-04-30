<?php
/**
 * index.php login.php
 *
 * @author   PE-Oliver89
 * @since    2024-04-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */
declare(strict_types=1);

include_once __DIR__ . "/../../../private/helpers/init.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'style.css' ?>">
    <script src="<?= WEB_JS_DIR ?>script.js"></script>
</head>

<body class="login-background">

<div class="container">
    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="<?= WEB_ROOT_DIR . 'api/doLogin' ?>" method="post">
        <h1>Welcome</h1>
        <div class="css-login-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="css-login-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="remember-forgot-check">
            <label><input type="checkbox" name="remember"> Remember me</label>
            <a href="#forgotpassword">Forgot password?</a> <!-- Update the href when forgot password page is ready -->
        </div>
        <br>
        <div class="wrap">
        <button type="submit" class="button-login">Login</button>
        </div>
        <div class="register">
            <p>Don't have an account? <a href="#register">Register</a></p>
            <!-- Update the href when the registration page is ready -->
        </div>
    </form>
</div>
</body>
</html>