<?php
require_once __DIR__ . '/../scripts/db.php';
require_once __DIR__ . '/../scripts/validation.php';

function request_form_get($request) {
    session_start();
    if (!empty($_SESSION['login']) && !empty($_SESSION['uid'])) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM form_users WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $request['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $data = [
        'values' => [],
        'errors' => [],
        'messages' => $_SESSION['messages'] ?? [],
    ];
    unset($_SESSION['messages']);
    
    if (!empty($request['user'])) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM form_requests WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$request['user']['id']]);
        $data['values'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    
    return theme('request_form', $data);
}

function request_form_post($request) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!empty($_SESSION['login']) && !empty($_SESSION['uid'])) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM form_users WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $request['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $values = $request['post'];
    $errors = validate_request($values);
    
    if (!empty($errors)) {
        return theme('request_form', ['values' => $values, 'errors' => $errors]);
    }
    
    $result = save_request($values, $request['user'] ?? null);
    
    if (!empty($request['user'])) {
        $_SESSION['messages'] = ['Данные обновлены!'];
    } else {
        $_SESSION['messages'] = [
            "Заявка отправлена! Логин: {$result['login']}, Пароль: {$result['password']}"
        ];
    }
    
    return redirect('');
}