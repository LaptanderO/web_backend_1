<?php
require_once __DIR__ . '/admin_auth.php';

$admin = authenticateAdmin($pdo);
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $pdo->prepare("DELETE FROM application_languages WHERE application_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM applications WHERE id = ?")->execute([$id]);
    $pdo->prepare("UPDATE users SET application_id = NULL WHERE application_id = ?")->execute([$id]);
}

header('Location: admin_panel.php');
exit();
?>

