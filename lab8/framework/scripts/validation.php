<?php
global $db;
if (!isset($db) || !$db) {
    include_once __DIR__ . '/db.php';
}
function validate_request($data) {
    $errors = [];
    
    if (empty(trim($data['name'] ?? ''))) {
        $errors['name'] = 'Введите имя';
    }
    
    $phone = trim($data['phone'] ?? '');
    if (empty($phone) || !preg_match('/^[\d\s\(\)\-\+]{7,20}$/', $phone)) {
        $errors['phone'] = 'Неверный формат телефона';
    }
    
    $email = trim($data['email'] ?? '');
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Неверный email';
    }
    
    if (empty($data['agreement'])) {
        $errors['agreement'] = 'Требуется согласие на обработку данных';
    }
    
    return $errors;
}

function save_request($data, $user = null) {
    global $db;
    
    $name = trim($data['name']);
    $phone = trim($data['phone']);
    $email = trim($data['email']);
    $comment = trim($data['comment'] ?? '');
    $agreement = !empty($data['agreement']) ? 1 : 0;
    
    $db->beginTransaction();
    
    try {
        if ($user) {
            $stmt = $db->prepare("UPDATE form_requests SET name=?, phone=?, email=?, comment=?, agreement=? WHERE user_id=?");
            $stmt->execute([$name, $phone, $email, $comment, $agreement, $user['id']]);
            $db->commit();
            return ['login' => $user['login']];
        } else {
            $login = 'user_' . substr(md5(uniqid(rand(), true)), 0, 8);
            $password = substr(md5(uniqid(rand(), true)), 0, 10);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("INSERT INTO form_users (login, password_hash) VALUES (?, ?)");
            $stmt->execute([$login, $password_hash]);
            $user_id = $db->lastInsertId();
            
            $stmt = $db->prepare("INSERT INTO form_requests (user_id, name, phone, email, comment, agreement) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $phone, $email, $comment, $agreement]);
            $request_id = $db->lastInsertId();
            
            $db->commit();
            
            return ['login' => $login, 'password' => $password, 'request_id' => $request_id];
        }
    } catch (Exception $e) {
        $db->rollBack();
        return ['error' => $e->getMessage()];
    }
}
