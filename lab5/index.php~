<?php
// index.php
require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');

$is_authorized = false;
$user_data = null;

if (!empty($_COOKIE[session_name()])) {
    session_start();
    if (!empty($_SESSION['login']) && !empty($_SESSION['uid'])) {
        $is_authorized = true;
        
        $stmt = $pdo->prepare("
            SELECT a.*, u.login 
            FROM applications a 
            JOIN users u ON u.application_id = a.id 
            WHERE u.id = ?
        ");
        $stmt->execute([$_SESSION['uid']]);
        $user_data = $stmt->fetch();
    }
}

$messages = [];

if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    
    if (!empty($_COOKIE['login']) && !empty($_COOKIE['pass'])) {
        $messages[] = sprintf(
            'Спасибо, результаты сохранены. Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong> и паролем <strong>%s</strong> для изменения данных.',
            htmlspecialchars($_COOKIE['login']),
            htmlspecialchars($_COOKIE['pass'])
        );
    } else {
        $messages[] = 'Спасибо, результаты сохранены.';
    }
}

// Признаки ошибок
$errors = [
    'full_name' => !empty($_COOKIE['full_name_error']),
    'phone' => !empty($_COOKIE['phone_error']),
    'email' => !empty($_COOKIE['email_error']),
    'birth_date' => !empty($_COOKIE['birth_date_error']),
    'gender' => !empty($_COOKIE['gender_error']),
    'languages' => !empty($_COOKIE['languages_error']),
    'biography' => !empty($_COOKIE['biography_error']),
    'agreed' => !empty($_COOKIE['agreed_error'])
];

$values = [
    'full_name' => $_COOKIE['full_name_value'] ?? '',
    'phone' => $_COOKIE['phone_value'] ?? '',
    'email' => $_COOKIE['email_value'] ?? '',
    'birth_date' => $_COOKIE['birth_date_value'] ?? '',
    'gender' => $_COOKIE['gender_value'] ?? '',
    'languages' => isset($_COOKIE['languages_value']) ? explode(',', $_COOKIE['languages_value']) : [],
    'biography' => $_COOKIE['biography_value'] ?? '',
    'agreed' => $_COOKIE['agreed_value'] ?? ''
];

if ($is_authorized && $user_data) {
    $values = [
        'full_name' => $user_data['full_name'],
        'phone' => $user_data['phone'],
        'email' => $user_data['email'],
        'birth_date' => $user_data['birth_date'],
        'gender' => $user_data['gender'],
        'languages' => [],
        'biography' => $user_data['biography'],
        'agreed' => $user_data['agreed']
    ];
    
    $stmt = $pdo->prepare("SELECT language_id FROM application_languages WHERE application_id = ?");
    $stmt->execute([$user_data['id']]);
    $values['languages'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

foreach (array_keys($errors) as $field) {
    if ($errors[$field]) {
        setcookie($field . '_error', '', 100000);
        setcookie($field . '_value', '', 100000);
        $messages[] = '<div class="error">Ошибка в поле: ' . $field . '</div>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $has_errors = false;
    
    $full_name = trim($_POST['full_name'] ?? '');
    if (empty($full_name) || strlen($full_name) > 150 || !preg_match('/^[a-zA-Zа-яА-ЯёЁ\s-]+$/', $full_name)) {
        setcookie('full_name_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('full_name_value', $full_name, time() + 30 * 24 * 60 * 60);
    
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone) || !preg_match('/^[+\-\s\(\)0-9]{10,20}$/', $phone)) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('phone_value', $phone, time() + 30 * 24 * 60 * 60);
    
    $email = trim($_POST['email'] ?? '');
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('email_value', $email, time() + 30 * 24 * 60 * 60);
    
    $birth_date = $_POST['birth_date'] ?? '';
    if (empty($birth_date)) {
        setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$d || $d->format('Y-m-d') !== $birth_date) {
            setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
            $has_errors = true;
        }
    }
    setcookie('birth_date_value', $birth_date, time() + 30 * 24 * 60 * 60);
    
    $gender = $_POST['gender'] ?? '';
    if (!in_array($gender, ['male', 'female'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60);
    
    $languages = $_POST['languages'] ?? [];
    if (empty($languages)) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } else {
        $placeholders = implode(',', array_fill(0, count($languages), '?'));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM languages WHERE id IN ($placeholders)");
        $stmt->execute($languages);
        if ($stmt->fetchColumn() != count($languages)) {
            setcookie('languages_error', '1', time() + 24 * 60 * 60);
            $has_errors = true;
        }
    }
    setcookie('languages_value', implode(',', $languages), time() + 30 * 24 * 60 * 60);
    
    $biography = trim($_POST['biography'] ?? '');
    if (empty($biography)) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('biography_value', $biography, time() + 30 * 24 * 60 * 60);
    
    $agreed = isset($_POST['agreed']) && $_POST['agreed'] == '1';
    if (!$agreed) {
        setcookie('agreed_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('agreed_value', $agreed ? '1' : '0', time() + 30 * 24 * 60 * 60);
    
    if ($has_errors) {
        header('Location: index.php');
        exit;
    }
    
    try {
        $pdo->beginTransaction();
        
        if ($is_authorized) {
            $stmt = $pdo->prepare("
                UPDATE applications 
                SET full_name = ?, phone = ?, email = ?, birth_date = ?, 
                    gender = ?, biography = ?, agreed = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $full_name, $phone, $email, $birth_date,
                $gender, $biography, $agreed ? 1 : 0,
                $user_data['id']
            ]);
            
            $stmt = $pdo->prepare("DELETE FROM application_languages WHERE application_id = ?");
            $stmt->execute([$user_data['id']]);
            
            $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
            foreach ($languages as $langId) {
                $stmt->execute([$user_data['id'], $langId]);
            }
            
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO applications (full_name, phone, email, birth_date, gender, biography, agreed)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $full_name, $phone, $email, $birth_date,
                $gender, $biography, $agreed ? 1 : 0
            ]);
            
            $applicationId = $pdo->lastInsertId();
            
            $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
            foreach ($languages as $langId) {
                $stmt->execute([$applicationId, $langId]);
            }
            
            $login = 'user_' . substr(md5(uniqid($applicationId, true)), 0, 8);
            $plain_password = substr(md5(uniqid(rand(), true)), 0, 8);
            $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, application_id) VALUES (?, ?, ?)");
            $stmt->execute([$login, $password_hash, $applicationId]);
            
            setcookie('login', $login, time() + 30 * 24 * 60 * 60);
            setcookie('pass', $plain_password, time() + 30 * 24 * 60 * 60);
        }
        
        $pdo->commit();

        foreach (array_keys($errors) as $field) {
            setcookie($field . '_error', '', 100000);
        }
        
        setcookie('save', '1', time() + 30 * 24 * 60 * 60);
        
        header('Location: index.php');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        setcookie('db_error', '1', time() + 24 * 60 * 60);
        header('Location: index.php');
        exit;
    }
}

include('form.php');
?>
