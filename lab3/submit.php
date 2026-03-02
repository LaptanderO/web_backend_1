<?php
// submit.php
session_start();
require_once 'config.php'; 

function validate() {
    $errors = [];
    $data = $_POST;
    
    // ФИО
    $full_name = trim($data['full_name'] ?? '');
    if (empty($full_name)) {
        $errors[] = 'Поле ФИО обязательно';
    } elseif (mb_strlen($full_name) > 150) {
        $errors[] = 'ФИО не должно превышать 150 символов';
    } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $full_name)) {
        $errors[] = 'ФИО должно содержать только буквы, пробелы и дефисы';
    }
    
    // Телефон
    $phone = trim($data['phone'] ?? '');
    if (empty($phone)) {
        $errors[] = 'Поле Телефон обязательно';
    } elseif (!preg_match('/^[\+\-\s\(\)0-9]{10,20}$/', $phone)) {
        $errors[] = 'Телефон содержит недопустимые символы';
    }
    
    // Email
    $email = trim($data['email'] ?? '');
    if (empty($email)) {
        $errors[] = 'Поле Email обязательно';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный формат email';
    }
    
    // Дата рождения
    $birth_date = $data['birth_date'] ?? '';
    if (empty($birth_date)) {
        $errors[] = 'Поле Дата рождения обязательно';
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$d || $d->format('Y-m-d') !== $birth_date) {
            $errors[] = 'Некорректный формат даты';
        }
    }
    
    // Пол
    $gender = $data['gender'] ?? '';
    if (!in_array($gender, ['male', 'female'])) {
        $errors[] = 'Некорректное значение пола';
    }
    
    // Языки
    $languages = $data['languages'] ?? [];
    if (empty($languages)) {
        $errors[] = 'Выберите хотя бы один язык программирования';
    } else {
        // Проверяем, что все ID существуют
        global $pdo;
        $placeholders = implode(',', array_fill(0, count($languages), '?'));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM languages WHERE id IN ($placeholders)");
        $stmt->execute($languages);
        if ($stmt->fetchColumn() != count($languages)) {
            $errors[] = 'Обнаружен недопустимый язык программирования';
        }
    }
    
    // Биография
    $biography = trim($data['biography'] ?? '');
    if (empty($biography)) {
        $errors[] = 'Поле Биография обязательно';
    }
    
    // Чекбокс
    $agreed = isset($data['agreed']) && $data['agreed'] == '1';
    if (!$agreed) {
        $errors[] = 'Необходимо подтвердить ознакомление с контрактом';
    }
    
    return [$errors, [
        'full_name' => $full_name,
        'phone' => $phone,
        'email' => $email,
        'birth_date' => $birth_date,
        'gender' => $gender,
        'languages' => $languages,
        'biography' => $biography,
        'agreed' => $agreed
    ]];
}

require_once 'config.php';

list($errors, $clean_data) = validate();

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
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
        $clean_data['full_name'],
        $clean_data['phone'],
        $clean_data['email'],
        $clean_data['birth_date'],
        $clean_data['gender'],
        $clean_data['biography'],
        $clean_data['agreed'] ? 1 : 0
    ]);
    
    $applicationId = $pdo->lastInsertId();
    
    $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
    foreach ($clean_data['languages'] as $langId) {
        $stmt->execute([$applicationId, $langId]);
    }
    
    $pdo->commit();
    
    $_SESSION['success'] = 'Данные успешно сохранены!';
    header('Location: index.php');
    exit;
    
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['errors'] = ['Ошибка базы данных: ' . $e->getMessage()];
    $_SESSION['old'] = $_POST;
    header('Location: index.php');
    exit;
}
