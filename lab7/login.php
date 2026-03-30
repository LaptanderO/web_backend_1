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

$maxAttempts = 5;
$lockoutTime = 900; 

if (isset($_SESSION['failed_login_attempts'])) {
    if ($_SESSION['failed_login_attempts'] >= $maxAttempts && 
        (time() - $_SESSION['last_failed_login']) < $lockoutTime) {
        $error_message = 'Слишком много попыток входа. Попробуйте через ' . 
                         ceil(($lockoutTime - (time() - $_SESSION['last_failed_login'])) / 60) . ' минут.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error_message)) {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        die('CSRF validation failed');
    }
    
    $login = safePostString('login');
    $password = $_POST['pass'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error_message = 'Заполните логин и пароль';
    } else {
        $stmt = $pdo->prepare("SELECT id, login, password_hash FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            unset($_SESSION['failed_login_attempts']);
            unset($_SESSION['last_failed_login']);
            
            if (!$session_started) {
                session_start();
            }
            $_SESSION['login'] = $user['login'];
            $_SESSION['uid'] = $user['id'];
            
            session_regenerate_id(true);
            
            $cookie_fields = ['full_name', 'phone', 'email', 'birth_date', 'gender', 'languages', 'biography', 'agreed'];
            foreach ($cookie_fields as $field) {
                setcookie($field . '_value', '', 100000);
                setcookie($field . '_error', '', 100000);
            }
            
            header('Location: ./');
            exit();
        } else {
            $_SESSION['failed_login_attempts'] = ($_SESSION['failed_login_attempts'] ?? 0) + 1;
            $_SESSION['last_failed_login'] = time();
            $error_message = 'Неверный логин или пароль';
        }
    }
}

$csrf_token = generateCSRFToken();
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
            <div class="error-box"><?= h($error_message) ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
            
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
