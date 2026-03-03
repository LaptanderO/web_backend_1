<?php
// index.php
require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');
$error_message = '';
$success_message = '';
$old_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $errors = [];
    
    $full_name = trim($_POST['full_name'] ?? '');
    if (empty($full_name)) {
        $errors[] = 'Поле ФИО обязательно';
    } elseif (strlen($full_name) > 150) {
        $errors[] = 'ФИО не должно превышать 150 символов';
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s-]+$/', $full_name)) {
        $errors[] = 'ФИО должно содержать только буквы, пробелы и дефисы';
    }
    
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors[] = 'Поле Телефон обязательно';
    } elseif (!preg_match('/^[+\-\s\(\)0-9]{10,20}$/', $phone)) {
        $errors[] = 'Телефон содержит недопустимые символы';
    }
    
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors[] = 'Поле Email обязательно';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный формат email';
    }
    
    $birth_date = $_POST['birth_date'] ?? '';
    if (empty($birth_date)) {
        $errors[] = 'Поле Дата рождения обязательно';
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$d || $d->format('Y-m-d') !== $birth_date) {
            $errors[] = 'Некорректный формат даты';
        }
    }
    
    $gender = $_POST['gender'] ?? '';
    if (!in_array($gender, ['male', 'female'])) {
        $errors[] = 'Некорректное значение пола';
    }
    
    $languages = $_POST['languages'] ?? [];
    if (empty($languages)) {
        $errors[] = 'Выберите хотя бы один язык программирования';
    } else {
        $placeholders = implode(',', array_fill(0, count($languages), '?'));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM languages WHERE id IN ($placeholders)");
        $stmt->execute($languages);
        if ($stmt->fetchColumn() != count($languages)) {
            $errors[] = 'Обнаружен недопустимый язык программирования';
        }
    }

    $biography = trim($_POST['biography'] ?? '');
    if (empty($biography)) {
        $errors[] = 'Поле Биография обязательно';
    }
    
    $agreed = isset($_POST['agreed']) && $_POST['agreed'] == '1';
    if (!$agreed) {
        $errors[] = 'Необходимо подтвердить ознакомление с контрактом';
    }
    
    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        $old_data = $_POST; 
    } else {
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
            
            header('Location: index.php?save=1');
            exit;
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = 'Ошибка базы данных: ' . $e->getMessage();
            $old_data = $_POST;
        }
    }
}

if (isset($_GET['save']) && $_GET['save'] == '1') {
    $success_message = 'Спасибо, результаты сохранены.';
}

include('form.php');
?>


