<?php
require_once __DIR__ . '/admin_auth.php';

if (!isset($_GET['csrf_token']) || !verifyCSRFToken($_GET['csrf_token'])) {
    die('CSRF validation failed');
}

$id = safeGetInt('id', 0);

if ($id > 0) {
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("DELETE FROM application_languages WHERE application_id = ?");
        $stmt->execute([$id]);
        
        $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
        $stmt->execute([$id]);
        
        $stmt = $pdo->prepare("UPDATE users SET application_id = NULL WHERE application_id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        $_SESSION['success_message'] = 'Запись успешно удалена';
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Delete error: " . $e->getMessage());
        $_SESSION['error_message'] = 'Ошибка при удалении';
    }
}

header('Location: admin_panel.php');
exit();
?>
