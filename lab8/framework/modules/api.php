<?php
require_once __DIR__ . '/../scripts/db.php';
require_once __DIR__ . '/../scripts/validation.php';

function api_post($request) {
    // Проверяем сессию
    session_start();
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
        return api_json(['success' => true, 'message' => 'Данные обновлены']);
    }
    
    return api_json([
        'success' => true,
        'login' => $result['login'],
        'password' => $result['password'],
        'profile_url' => '/api/requests/' . $result['request_id']
    ], 201);
}

function api_json($data, $code = 200) {
    http_response_code($code);
    return [
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'entity' => json_encode($data, JSON_UNESCAPED_UNICODE)
    ];
}