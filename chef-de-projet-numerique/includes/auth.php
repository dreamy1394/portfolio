<?php
require_once __DIR__ . '/config.php';

function login($email, $password) {
    if ($email === ADMIN_EMAIL && password_verify($password, ADMIN_PASSWORD)) {
        session_start();
        $_SESSION['admin'] = true;
        $_SESSION['last_activity'] = time();
        return true;
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
}

function checkSessionTimeout() {
    session_start();
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) { // 30 minutes d'inactivité
        logout();
        header('Location: /admin/login.php?error=timeout');
        exit;
    }
    $_SESSION['last_activity'] = time();
}
