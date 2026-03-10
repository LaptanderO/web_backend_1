<?php
// index.php
require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');

$messages = [];

if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000); 
    $messages[] = 'Спасибо, результаты сохранены.';
}

$errors = [];
$errors['full_name'] = !empty($_COOKIE['full_name_error']);
$errors['phone'] = !empty($_COOKIE['phone_error']);
$errors['email'] = !empty($_COOKIE['email_error']);
$errors['birth_date'] = !empty($_COOKIE['birth_date_error']);
$errors['gender'] = !empty($_COOKIE['gender_error']);
$errors['languages'] = !empty($_COOKIE['languages_error']);
$errors['biography'] = !empty($_COOKIE['biography_error']);
$errors['agreed'] = !empty($_COOKIE['agreed_error']);

$values = [];
$values['full_name'] = $_COOKIE['full_name_value'] ?? '';
$values['phone'] = $_COOKIE['phone_value'] ?? '';
$values['email'] = $_COOKIE['email_value'] ?? '';
$values['birth_date'] = $_COOKIE['birth_date_value'] ?? '';
$values['gender'] = $_COOKIE['gender_value'] ?? '';
$values['languages'] = isset($_COOKIE['languages_value']) ? explode(',', $_COOKIE['languages_value']) : [];
$values['biography'] = $_COOKIE['biography_value'] ?? '';
$values['agreed'] = $_COOKIE['agreed_value'] ?? '';

if ($errors['full_name']) {
    setcookie('full_name_error', '', 100000);
    setcookie('full_name_value', '', 100000);
    $messages[] = '<div class="error">ФИО должно содержать только буквы, пробелы и дефисы.</div>';
}

if ($errors['phone']) {
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    $messages[] = '<div class="error">Телефон должен содержать только цифры, пробелы, дефисы, плюс и скобки (10-20 символов).</div>';
}

if ($errors['email']) {
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    $messages[] = '<div class="error">Некорректный формат email.</div>';
}

if ($errors['birth_date']) {
    setcookie('birth_date_error', '', 100000);
    setcookie('birth_date_value', '', 100000);
    $messages[] = '<div class="error">Некорректная дата рождения (формат ГГГГ-ММ-ДД).</div>';
}

if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    setcookie('gender_value', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
}

if ($errors['languages']) {
    setcookie('languages_error', '', 100000);
    setcookie('languages_value', '', 100000);
    $messages[] = '<div class="error">Выберите хотя бы один язык программирования.</div>';
}

if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    setcookie('biography_value', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
}

if ($errors['agreed']) {
    setcookie('agreed_error', '', 100000);
    setcookie('agreed_value', '', 100000);
    $messages[] = '<div class="error">Необходимо подтвердить ознакомление с контрактом.</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $has_errors = false;
    
    // ФИО
    $full_name = trim($_POST['full_name'] ?? '');
    if (empty($full_name)) {
        setcookie('full_name_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } elseif (strlen($full_name) > 150) {
        setcookie('full_name_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s-]+$/', $full_name)) {
        setcookie('full_name_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('full_name_value', $full_name, time() + 30 * 24 * 60 * 60);
    
    // Телефон
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } elseif (!preg_match('/^[+\-\s\(\)0-9]{10,20}$/', $phone)) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('phone_value', $phone, time() + 30 * 24 * 60 * 60);
    
    // Email
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('email_value', $email, time() + 30 * 24 * 60 * 60);
    
    // Дата рождения
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
    
    // Пол
    $gender = $_POST['gender'] ?? '';
    if (!in_array($gender, ['male', 'female'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60);
    
    // Языки
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
    
    // Биография
    $biography = trim($_POST['biography'] ?? '');
    if (empty($biography)) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $has_errors = true;
    }
    setcookie('biography_value', $biography, time() + 30 * 24 * 60 * 60);
    
    // Чекбокс
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
        
        $stmt = $pdo->prepare("
            INSERT INTO applications (full_name, phone, email, birth_date, gender, biography, agreed)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $full_name,
            $phone,
            $email,
            $birth_date,
            $gender,
            $biography,
            $agreed ? 1 : 0
        ]);
        
        $applicationId = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
        foreach ($languages as $langId) {
            $stmt->execute([$applicationId, $langId]);
        }
        
        $pdo->commit();
        
        $error_fields = ['full_name', 'phone', 'email', 'birth_date', 'gender', 'languages', 'biography', 'agreed'];
        foreach ($error_fields as $field) {
            setcookie($field . '_error', '', 100000);
        }
        
        setcookie('save', '1', time() + 365 * 24 * 60 * 60);
        
        header('Location: index.php');
        exit;
        
    } catch (PDOException $e) {
        setcookie('db_error', '1', time() + 24 * 60 * 60);
        header('Location: index.php');
        exit;
    }
}

include('form.php');
?>
