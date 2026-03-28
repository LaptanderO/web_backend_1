<?php
// login.php
require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if (!empty($_COOKIE[session_name()])) {
    session_start();
    $session_started = true;
    if (!empty($_SESSION['login'])) {
        header('Location: ./');
        exit();
    }
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['pass'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error_message = 'Заполните логин и пароль';
    } else {
        $stmt = $pdo->prepare("SELECT id, login, password_hash FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            if (!$session_started) {
                session_start();
            }
            $_SESSION['login'] = $user['login'];
            $_SESSION['uid'] = $user['id'];
            
            $cookie_fields = ['full_name', 'phone', 'email', 'birth_date', 'gender', 'languages', 'biography', 'agreed'];
            foreach ($cookie_fields as $field) {
                setcookie($field . '_value', '', 100000);
                setcookie($field . '_error', '', 100000);
            }
            
            header('Location: ./');
            exit();
        } else {
            $error_message = 'Неверный логин или пароль';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в систему</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Вход для редактирования анкеты</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required>
            
            <label for="pass">Пароль:</label>
            <input type="password" id="pass" name="pass" required>
            
            <button type="submit">Войти</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px;">
            <a href="./">Вернуться к форме</a>
        </p>
    </div>
</body>
</html>
