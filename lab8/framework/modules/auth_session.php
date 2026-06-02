<?php
function auth(&$request, $r) {
    session_start();
    
    if (!empty($_SESSION['login']) && !empty($_SESSION['uid'])) {
        global $db;
        $stmt = $db->prepare("SELECT u.*, r.id as request_id FROM form_users u LEFT JOIN form_requests r ON r.user_id = u.id WHERE u.id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $request['user'] = $user;
            return;
        }
    }
    
    return [
        'headers' => ['HTTP/1.0 401 Unauthorized'],
        'entity' => json_encode(['error' => 'Authentication required']),
    ];
}
