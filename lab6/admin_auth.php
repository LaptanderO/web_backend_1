<?php
require_once __DIR__ . '/config.php';

function authenticateAdmin($pdo) {
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
            file_put_contents(__DIR__ . '/auth_debug.log', "User found in DB. Verifying password...\n", FILE_APPEND);
            
            if (password_verify($password, $admin['password_hash'])) {
                file_put_contents(__DIR__ . '/auth_debug.log', "SUCCESS!\n", FILE_APPEND);
                return $admin;
            } else {
                file_put_contents(__DIR__ . '/auth_debug.log', "Password mismatch!\n", FILE_APPEND);
            }
        } else {
            file_put_contents(__DIR__ . '/auth_debug.log', "User NOT found in DB!\n", FILE_APPEND);
        }
    } catch (PDOException $e) {
        file_put_contents(__DIR__ . '/auth_debug.log', "DB Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
    
    sendAuthHeaders();
    return false;
}

function sendAuthHeaders() {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Admin Panel"');
    echo '<h1>401 Unauthorized</h1><p>Invalid login or password</p>';
    exit();
}
?>

