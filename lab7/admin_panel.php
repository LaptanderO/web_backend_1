<?php
require_once __DIR__ . '/admin_auth.php';

$admin = authenticateAdmin($pdo);

try {
    // SQL injection защита - используем подготовленные запросы
    $stmt = $pdo->prepare("
        SELECT a.*, u.login as user_login
        FROM applications a
        LEFT JOIN users u ON u.application_id = a.id
        ORDER BY a.created_at DESC
    ");
    $stmt->execute();
    $applications = $stmt->fetchAll();
    
    foreach ($applications as &$app) {
        $stmt = $pdo->prepare("
            SELECT l.name 
            FROM languages l
            JOIN application_languages al ON l.id = al.language_id
            WHERE al.application_id = ?
            ORDER BY l.name
        ");
        $stmt->execute([$app['id']]);
        $langs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $app['languages_list'] = implode(', ', $langs);
    }
    
    $stmt = $pdo->prepare("
        SELECT l.name, COUNT(al.application_id) as count
        FROM languages l
        LEFT JOIN application_languages al ON l.id = al.language_id
        GROUP BY l.id, l.name
        ORDER BY count DESC, l.name
    ");
    $stmt->execute();
    $stats = $stmt->fetchAll();
    
    $total = count($applications);
    
} catch (PDOException $e) {
    error_log("Admin panel error: " . $e->getMessage());
    die("Ошибка загрузки данных. Пожалуйста, попробуйте позже.");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 4px 8px; text-decoration: none; margin: 2px; border-radius: 3px; display: inline-block; }
        .btn-edit { background: #4CAF50; color: white; }
        .btn-delete { background: #f44336; color: white; }
        .stats { display: flex; gap: 10px; flex-wrap: wrap; margin: 20px 0; }
        .stat-card { background: #f0f0f0; padding: 10px; border-radius: 5px; min-width: 100px; text-align: center; }
        .stat-number { font-size: 24px; font-weight: bold; color: #667eea; }
        .admin-info { background: #e3f2fd; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Admin Panel</h1>
    </div>
    
    <div class="admin-info">
        👋 Logged in as: <strong><?= h($_SERVER['PHP_AUTH_USER']) ?></strong>
    </div>
    
    <h2>📈 Statistics by Language</h2>
    <div class="stats">
        <?php if (empty($stats)): ?>
            <p>No statistics available.</p>
        <?php else: ?>
            <?php foreach ($stats as $stat): ?>
                <div class="stat-card">
                    <div class="stat-number"><?= h($stat['count']) ?></div>
                    <div><?= h($stat['name']) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <h2>📋 All Applications (<?= h($total) ?>)</h2>
    
    <?php if (empty($applications)): ?>
        <p>No applications yet. Please fill out the form first.</p>
        <p><a href="../index.php">Go to form →</a></p>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                        <th>Languages</th>
                        <th>User</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= h($app['id']) ?></td>
                            <td><?= h($app['full_name']) ?></td>
                            <td><?= h($app['phone']) ?></td>
                            <td><?= h($app['email']) ?></td>
                            <td><?= h($app['birth_date']) ?></td>
                            <td><?= $app['gender'] == 'male' ? 'Male' : 'Female' ?></td>
                            <td><?= h($app['languages_list'] ?: '-') ?></td>
                            <td><?= h($app['user_login'] ?? '-') ?></td>
                            <td>
                                <a href="admin_edit.php?id=<?= h($app['id']) ?>" class="btn btn-edit">✏️ Edit</a>
                                <a href="admin_delete.php?id=<?= h($app['id']) ?>" class="btn btn-delete" onclick="return confirm('Delete?')">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;"><a href="../index.php">← Back to main form</a></p>
</body>
</html>
