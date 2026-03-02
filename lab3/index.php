<?php
// index.php
session_start();
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Анкета</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Заполните анкету</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-box">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="submit.php" method="POST">
            <!-- 1. ФИО -->
            <label for="full_name">ФИО:</label>
            <input type="text" id="full_name" name="full_name" 
                   value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required>

            <!-- 2. Телефон -->
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" 
                   value="<?= htmlspecialchars($old['phone'] ?? '') ?>" required>

            <!-- 3. Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>

            <!-- 4. Дата рождения -->
            <label for="birth_date">Дата рождения:</label>
            <input type="date" id="birth_date" name="birth_date" 
                   value="<?= htmlspecialchars($old['birth_date'] ?? '') ?>" required>

            <!-- 5. Пол -->
            <label>Пол:</label>
            <div class="radio-group">
                <input type="radio" id="male" name="gender" value="male" 
                       <?= (isset($old['gender']) && $old['gender'] == 'male') ? 'checked' : '' ?> required>
                <label for="male">Мужской</label>
                
                <input type="radio" id="female" name="gender" value="female" 
                       <?= (isset($old['gender']) && $old['gender'] == 'female') ? 'checked' : '' ?> required>
                <label for="female">Женский</label>
            </div>

            <!-- 6. Любимые ЯП  -->
            <label for="languages">Любимые языки программирования:</label>
            <select name="languages[]" id="languages" multiple required>
                <?php
                $user = 'ваш_логин';
                $pass = 'ваш_пароль';
                $db = new PDO("mysql:host=localhost;dbname=$user;charset=utf8mb4", $user, $pass);
                
                $stmt = $db->query("SELECT id, name FROM languages ORDER BY name");
                $all_languages = $stmt->fetchAll();
                $old_langs = $old['languages'] ?? [];
                
                foreach ($all_languages as $lang):
                    $selected = in_array($lang['id'], $old_langs) ? 'selected' : '';
                ?>
                    <option value="<?= $lang['id'] ?>" <?= $selected ?>>
                        <?= htmlspecialchars($lang['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- 7. Биография -->
            <label for="biography">Биография:</label>
            <textarea id="biography" name="biography" rows="5" required><?= 
                htmlspecialchars($old['biography'] ?? '') 
            ?></textarea>

            <!-- 8. Чекбокс согласия -->
            <div class="checkbox-group">
                <input type="checkbox" id="agreed" name="agreed" value="1" 
                       <?= (isset($old['agreed']) && $old['agreed'] == '1') ? 'checked' : '' ?> required>
                <label for="agreed">С контрактом ознакомлен(а)</label>
            </div>

            <!-- 9. Кнопка -->
            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
