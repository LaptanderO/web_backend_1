<?php
// admin_edit.php 
require_once __DIR__ . '/admin_auth.php';

$admin = authenticateAdmin($pdo);
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ?");
$stmt->execute([$id]);
$application = $stmt->fetch();

if (!$application) {
    header('Location: index.php?error=Анкета не найдена');
    exit();
}

$stmt = $pdo->prepare("SELECT language_id FROM application_languages WHERE application_id = ?");
$stmt->execute([$id]);
$selected_languages = $stmt->fetchAll(PDO::FETCH_COLUMN);

$all_languages = $pdo->query("SELECT id, name FROM languages ORDER BY name")->fetchAll();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $biography = trim($_POST['biography'] ?? '');
    $agreed = isset($_POST['agreed']) ? 1 : 0;
    $languages = $_POST['languages'] ?? [];
    
    $errors = [];
    
    if (empty($full_name) || strlen($full_name) > 150 || !preg_match('/^[a-zA-Zа-яА-ЯёЁ\s-]+$/', $full_name)) {
        $errors[] = 'ФИО заполнено некорректно';
    }
    if (empty($phone) || !preg_match('/^[+\-\s\(\)0-9]{10,20}$/', $phone)) {
        $errors[] = 'Телефон заполнен некорректно';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email заполнен некорректно';
    }
    if (empty($birth_date)) {
        $errors[] = 'Дата рождения не указана';
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$d || $d->format('Y-m-d') !== $birth_date) {
            $errors[] = 'Дата рождения некорректна';
        }
    }
    if (!in_array($gender, ['male', 'female'])) {
        $errors[] = 'Пол не выбран';
    }
    if (empty($biography)) {
        $errors[] = 'Биография не заполнена';
    }
    if (!$agreed) {
        $errors[] = 'Необходимо согласие с контрактом';
    }
    if (empty($languages)) {
        $errors[] = 'Выберите хотя бы один язык';
    }
    
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("
                UPDATE applications 
                SET full_name = ?, phone = ?, email = ?, birth_date = ?, 
                    gender = ?, biography = ?, agreed = ?
                WHERE id = ?
            ");
            $stmt->execute([$full_name, $phone, $email, $birth_date, $gender, $biography, $agreed, $id]);
            
            $stmt = $pdo->prepare("DELETE FROM application_languages WHERE application_id = ?");
            $stmt->execute([$id]);
            
            $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
            foreach ($languages as $langId) {
                $stmt->execute([$id, $langId]);
            }
            
            $pdo->commit();
            $success = 'Анкета успешно обновлена';
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Ошибка: ' . $e->getMessage();
        }
    } else {
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование анкеты #<?= $id ?></title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container-small">
        <h1>✏️ Редактирование анкеты #<?= $id ?></h1>
        
        <?php if ($success): ?>
            <div class="message">✅ <?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error">❌ <?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label>ФИО:</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($application['full_name']) ?>" required>
            
            <label>Телефон:</label>
            <input type="tel" name="phone" value="<?= htmlspecialchars($application['phone']) ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($application['email']) ?>" required>
            
            <label>Дата рождения:</label>
            <input type="date" name="birth_date" value="<?= $application['birth_date'] ?>" required>
            
            <label>Пол:</label>
            <div class="radio-group">
                <input type="radio" name="gender" value="male" id="male" <?= $application['gender'] == 'male' ? 'checked' : '' ?>>
                <label for="male">Мужской</label>
                <input type="radio" name="gender" value="female" id="female" <?= $application['gender'] == 'female' ? 'checked' : '' ?>>
                <label for="female">Женский</label>
            </div>
            
            <label>Языки программирования:</label>
            <select name="languages[]" multiple required>
                <?php foreach ($all_languages as $lang): ?>
                    <option value="<?= $lang['id'] ?>" <?= in_array($lang['id'], $selected_languages) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lang['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label>Биография:</label>
            <textarea name="biography" rows="5" required><?= htmlspecialchars($application['biography']) ?></textarea>
            
            <div class="checkbox-group">
                <input type="checkbox" name="agreed" value="1" id="agreed" <?= $application['agreed'] ? 'checked' : '' ?>>
                <label for="agreed">С контрактом ознакомлен(а)</label>
            </div>
            
            <button type="submit">💾 Сохранить изменения</button>
        </form>
        
        <a href="index.php" class="back-link">← Назад к списку</a>
    </div>
</body>
</html>
