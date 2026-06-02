<?php
require_once __DIR__ . '/../scripts/validation.php';

function api_post($request) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        return api_json(['error' => 'Invalid JSON'], 400);
    }
    
    $errors = validate_request($input);
    if (!empty($errors)) {
        return api_json(['errors' => $errors], 400);
    }
    
    $result = save_request($input);
    
    return api_json([
        'success' => true,
        'login' => $result['login'],
        'password' => $result['password'],
        'profile_url' => '/api/requests/' . $result['request_id']
    ], 201);
}

function api_put($id, $request) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    global $db;
    $stmt = $db->prepare("SELECT id FROM form_requests WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $request['user']['id']]);
    
    if (!$stmt->fetch()) {
        return api_json(['error' => 'Not found or forbidden'], 403);
    }
    
    $errors = validate_request($input);
    if (!empty($errors)) {
        return api_json(['errors' => $errors], 400);
    }
    
    save_request($input, $request['user']);
    
    return api_json(['success' => true]);
}

function api_json($data, $code = 200) {
    http_response_code($code);
    return [
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'entity' => json_encode($data, JSON_UNESCAPED_UNICODE)
    ];
}