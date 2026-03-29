<?php
// admin/delete.php 
require_once __DIR__ . '/auth.php';

$admin = authenticateAdmin($pdo);
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("SELECT full_name FROM applications WHERE id = ?");
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        
        $stmt = $pdo->prepare("DELETE FROM application_languages WHERE application_id = ?");
        $stmt->execute([$id]);
        
        $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
        $stmt->execute([$id]);
        
        $stmt = $pdo->prepare("UPDATE users SET application_id = NULL WHERE application_id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        header('Location: index.php?message=Анкета "' . urlencode($name) . '" удалена');
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        header('Location: index.php?error=Ошибка: ' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?error=Неверный ID');
}
exit();
