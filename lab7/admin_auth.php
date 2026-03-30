<?php
require_once __DIR__ . '/config.php';

function authenticateAdmin($pdo) {
    $maxAttempts = 5;
    $lockoutTime = 900; 
    
    if (isset($_SESSION['failed_auth_attempts'])) {
        if ($_SESSION['failed_auth_attempts'] >= $maxAttempts && 
            (time() - $_SESSION['last_failed_auth']) < $lockoutTime) {
            header('HTTP/1.1 429 Too Many Requests');
            echo '<h1>429 Too Many Requests</h1><p>Слишком много попыток входа. Попробуйте позже.</p>';
            exit();
        }
    }
    
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        sendAuthHeaders();
        return false;
    }
    
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            if (password_verify($password, $admin['password_hash'])) {
                unset($_SESSION['failed_auth_attempts']);
                unset($_SESSION['last_failed_auth']);
                return $admin;
            } else {
                $_SESSION['failed_auth_attempts'] = ($_SESSION['failed_auth_attempts'] ?? 0) + 1;
                $_SESSION['last_failed_auth'] = time();
            }
        }
    } catch (PDOException $e) {
        error_log("Auth DB Error: " . $e->getMessage());
    }
    
    sendAuthHeaders();
    return false;
}

function sendAuthHeaders() {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Admin Panel"');
    echo '<h1>401 Unauthorized</h1><p>Неверный логин или пароль</p>';
    exit();
}
?>
