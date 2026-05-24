<?php
function login_get($request) {
    return theme('login', []);
}

function login_post($request) {
    $login = trim($request['post']['login'] ?? '');
    $password = $request['post']['password'] ?? '';
    
    global $db;
    $stmt = $db->prepare("SELECT id, login, password_hash FROM form_users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        session_start();
        $_SESSION['login'] = $user['login'];
        $_SESSION['uid'] = $user['id'];
        return redirect('');
    }
    
    return theme('login', ['error' => 'Неверный логин или пароль']);
}
