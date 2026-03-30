<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Анкета программиста</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Заполните анкету</h1>

        <?php if (!empty($messages)): ?>
            <div id="messages" class="messages-box">
                <?php foreach ($messages as $message): ?>
                    <div><?= $message ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_COOKIE['login']) && !empty($_COOKIE['pass']) && empty($_SESSION['login'])): ?>
            <div class="success-box" style="background: #e8f5e9; border-left: 4px solid #2e7d32; padding: 15px; margin-bottom: 20px;">
                <strong>✓ Ваши данные для входа:</strong><br>
                <strong>Логин:</strong> <?= h($_COOKIE['login']) ?><br>
                <strong>Пароль:</strong> <?= h($_COOKIE['pass']) ?><br>
                <small style="color: #666;">Сохраните их, чтобы потом изменить анкету</small>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['login'])): ?>
            <div class="success-box" style="background: #e3f2fd; border-left: 4px solid #1976d2; padding: 15px; margin-bottom: 20px;">
                <strong>✓ Вы авторизованы как:</strong> <?= h($_SESSION['login']) ?><br>
                <small>Вы можете редактировать свои данные</small>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- CSRF токен -->
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
            
            <!-- 1. ФИО -->
            <label for="full_name">ФИО:</label>
            <input type="text" id="full_name" name="full_name" 
                   value="<?= h($values['full_name'] ?? '') ?>"
                   <?= !empty($errors['full_name']) ? 'class="error"' : '' ?>>
            <?php if (!empty($errors['full_name'])): ?>
                <div class="error-message">Разрешены только буквы, пробелы и дефисы (макс. 150 символов)</div>
            <?php endif; ?>

            <!-- 2. Телефон -->
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" 
                   value="<?= h($values['phone'] ?? '') ?>"
                   <?= !empty($errors['phone']) ? 'class="error"' : '' ?>>
            <?php if (!empty($errors['phone'])): ?>
                <div class="error-message">Разрешены только цифры, пробелы, дефисы, плюс и скобки (10-20 символов)</div>
            <?php endif; ?>

            <!-- 3. Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?= h($values['email'] ?? '') ?>"
                   <?= !empty($errors['email']) ? 'class="error"' : '' ?>>
            <?php if (!empty($errors['email'])): ?>
                <div class="error-message">Введите корректный email адрес</div>
            <?php endif; ?>

            <!-- 4. Дата рождения -->
            <label for="birth_date">Дата рождения:</label>
            <input type="date" id="birth_date" name="birth_date" 
                   value="<?= h($values['birth_date'] ?? '') ?>"
                   <?= !empty($errors['birth_date']) ? 'class="error"' : '' ?>>
            <?php if (!empty($errors['birth_date'])): ?>
                <div class="error-message">Введите корректную дату в формате ГГГГ-ММ-ДД</div>
            <?php endif; ?>

            <!-- 5. Пол -->
            <label>Пол:</label>
            <div class="radio-group <?= !empty($errors['gender']) ? 'error' : '' ?>">
                <input type="radio" id="male" name="gender" value="male" 
                       <?= ($values['gender'] ?? '') == 'male' ? 'checked' : '' ?>>
                <label for="male">Мужской</label>
                
                <input type="radio" id="female" name="gender" value="female" 
                       <?= ($values['gender'] ?? '') == 'female' ? 'checked' : '' ?>>
                <label for="female">Женский</label>
            </div>
            <?php if (!empty($errors['gender'])): ?>
                <div class="error-message">Выберите пол</div>
            <?php endif; ?>

            <!-- 6. Любимые ЯП -->
            <label for="languages">Любимые языки программирования:</label>
            <select name="languages[]" id="languages" multiple <?= !empty($errors['languages']) ? 'class="error"' : '' ?>>
                <?php
                $stmt = $pdo->query("SELECT id, name FROM languages ORDER BY name");
                $all_languages = $stmt->fetchAll();
                $selected_langs = $values['languages'] ?? [];
                
                foreach ($all_languages as $lang):
                    $selected = in_array($lang['id'], $selected_langs) ? 'selected' : '';
                ?>
                    <option value="<?= h($lang['id']) ?>" <?= $selected ?>>
                        <?= h($lang['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['languages'])): ?>
                <div class="error-message">Выберите хотя бы один язык программирования</div>
            <?php endif; ?>

            <!-- 7. Биография -->
            <label for="biography">Биография:</label>
            <textarea id="biography" name="biography" rows="5" <?= !empty($errors['biography']) ? 'class="error"' : '' ?>><?= 
                h($values['biography'] ?? '') 
            ?></textarea>
            <?php if (!empty($errors['biography'])): ?>
                <div class="error-message">Заполните биографию</div>
            <?php endif; ?>

            <!-- 8. Чекбокс согласия -->
            <div class="checkbox-group <?= !empty($errors['agreed']) ? 'error' : '' ?>">
                <input type="checkbox" id="agreed" name="agreed" value="1" 
                       <?= ($values['agreed'] ?? '') == '1' ? 'checked' : '' ?>>
                <label for="agreed">С контрактом ознакомлен(а)</label>
            </div>
            <?php if (!empty($errors['agreed'])): ?>
                <div class="error-message">Необходимо подтвердить ознакомление с контрактом</div>
            <?php endif; ?>

            <!-- 9. Кнопка -->
            <button type="submit">Сохранить</button>
        </form>

        <?php if (!empty($_SESSION['login'])): ?>
            <div style="margin-top: 20px; text-align: center; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                <p style="margin-bottom: 10px;">Вы вошли как: <strong><?= h($_SESSION['login']) ?></strong></p>
                <a href="logout.php" style="color: #667eea; text-decoration: none; padding: 8px 16px; background: #f0f0f0; border-radius: 5px;">Выйти</a>
            </div>
        <?php endif; ?>
        
        <?php if (empty($_SESSION['login'])): ?>
            <div style="margin-top: 20px; text-align: center;">
                <p>Уже есть аккаунт? <a href="login.php" style="color: #667eea;">Войти для редактирования</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
