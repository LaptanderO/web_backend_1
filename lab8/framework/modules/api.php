<?php
require_once __DIR__ . '/../scripts/db.php';
require_once __DIR__ . '/../scripts/validation.php';

function api_post($request) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!empty($_SESSION['login']) && !empty($_SESSION['uid'])) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM form_users WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $request['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        return api_json(['error' => 'Invalid JSON'], 400);
    }
    
    $errors = validate_request($input);
    if (!empty($errors)) {
        return api_json(['errors' => $errors], 400);
    }
    
    $result = save_request($input, $request['user'] ?? null);
    
    if (!empty($request['user'])) {
        return api_json([
            'success' => true, 
            'message' => 'Данные обновлены!',
            'is_edit' => true
        ]);
    }
    
    return api_json([
        'success' => true,
        'login' => $result['login'],
        'password' => $result['password'],
        'message' => 'Заявка отправлена!',
        'is_edit' => false
    ], 201);
}

function api_json($data, $code = 200) {
    http_response_code($code);
    return [
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'entity' => json_encode($data, JSON_UNESCAPED_UNICODE)
    ];
}