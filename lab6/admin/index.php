<?php
// admin/index.php 
require_once __DIR__ . '/auth.php';

$admin = authenticateAdmin($pdo);

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

$stmt = $pdo->query("
    SELECT a.*, 
           GROUP_CONCAT(l.name ORDER BY l.name SEPARATOR ', ') as languages_list,
           u.login as user_login
    FROM applications a
    LEFT JOIN application_languages al ON a.id = al.application_id
    LEFT JOIN languages l ON al.language_id = l.id
    LEFT JOIN users u ON u.application_id = a.id
    GROUP BY a.id
    ORDER BY a.created_at DESC
");
$applications = $stmt->fetchAll();

// Статистика по языкам
$stmt = $pdo->query("
    SELECT l.id, l.name, COUNT(al.application_id) as count
    FROM languages l
    LEFT JOIN application_languages al ON l.id = al.language_id
    GROUP BY l.id
    ORDER BY count DESC, l.name
");
$stats = $stmt->fetchAll();

$total = count($applications);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>
            📊 Админ-панель
            <span class="total-badge">Всего: <?= $total ?></span>
        </h1>
        <div class="admin-info">
            👋 Вы вошли как: <strong><?= htmlspecialchars($admin['username']) ?></strong>
        </div>
        
        <?php if ($message): ?>
            <div class="message">✅ <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error">❌ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <!-- Статистика -->
        <div class="stats-section">
            <h2>📈 Статистика по языкам программирования</h2>
            <div class="stats-grid">
                <?php foreach ($stats as $stat): ?>
                    <div class="stat-card">
                        <div class="stat-number"><?= $stat['count'] ?></div>
                        <div class="stat-name"><?= htmlspecialchars($stat['name']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Таблица анкет -->
        <h2>📋 Все анкеты</h2>
        
        <?php if (empty($applications)): ?>
            <div class="empty-state">
                📭 Пока нет ни одной заполненной анкеты
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Дата рожд.</th>
                            <th>Пол</th>
                            <th>Языки</th>
                            <th>Пользователь</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td><?= $app['id'] ?></td>
                                <td><?= htmlspecialchars($app['full_name']) ?></td>
                                <td><?= htmlspecialchars($app['phone']) ?></td>
                                <td><?= htmlspecialchars($app['email']) ?></td>
                                <td><?= $app['birth_date'] ?></td>
                                <td><?= $app['gender'] == 'male' ? 'Мужской' : 'Женский' ?></td>
                                <td style="max-width: 200px;"><?= htmlspecialchars($app['languages_list'] ?? '-') ?></td>
                                <td>
                                    <?php if ($app['user_login']): ?>
                                        <?= htmlspecialchars($app['user_login']) ?>
                                    <?php else: ?>
                                        <span class="badge">нет аккаунта</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $app['id'] ?>" class="btn-edit" title="Редактировать">✏️</a>
                                    <a href="delete.php?id=<?= $app['id'] ?>" 
                                       class="btn-delete" 
                                       title="Удалить"
                                       onclick="return confirm('Удалить анкету <?= htmlspecialchars($app['full_name']) ?>?')">
                                       🗑️
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="../" class="back-link">← На главную</a>
        </div>
    </div>
</body>
</html>
