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

use Project\Services\LoginHandler;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once PRJ_SRC_DIR . "Project\Services\loginHandler.php";
$error = '';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $loginHandler = new loginHandler();
        try {
            $loginSuccess = $loginHandler->login($username, $password);
            if ($loginSuccess) {
                header("Location: " . WEB_ROOT_DIR . "HomePage.php");
                exit;
            } else {
                $error = "Login failed. Please check your username and password.";
            }
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
        }
    }
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
    <!--form action="<?= WEB_ROOT_DIR . 'Project/Services/LoginHandler.php' ?>" method="post"-->
    <form action="" method="post">
        <h1>Welcome</h1>
        <div class="css-login-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="css-login-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
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
<footer>
    <p class="footer-text">designed by <a href="https://br.freepik.com/vetores-gratis/fundo-gradiente-preto-com-cubos_19538131.htm#query=plano%20de%20fundo%20para%20sites&position=30&from_view=keyword&track=ais&uuid=2b9efc2d-4088-4cd1-824e-40763da61012">Freepik</a></p>
</footer>
</html>