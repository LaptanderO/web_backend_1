<?php
// admin_auth.php - Функции HTTP-авторизации
require_once __DIR__ . '/config.php';

function authenticateAdmin($pdo) {
    if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
        sendAuthHeaders();
        return false;
    }
    
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password_hash'])) {
        return $admin;
    }
    
    sendAuthHeaders();
    return false;
}

function sendAuthHeaders() {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Admin Panel - Survey System"');
    
    echo '<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Требуется авторизация</title>
        <link rel="stylesheet" href="admin.css">
    </head>
    <body>
        <div class="container-small">
            <h1 style="color: #f44336;">🔒 Требуется авторизация</h1>
            <p>Доступ разрешен только администраторам.</p>
            <p>Пожалуйста, введите логин и пароль администратора.</p>
            <a href="index.php" class="back-link">← Вернуться на главную</a>
        </div>
    </body>
    </html>';
    exit();
}
?>
