<?php
require_once __DIR__ . '/admin_auth.php';

$admin = authenticateAdmin($pdo);
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ?");
$stmt->execute([$id]);
$app = $stmt->fetch();

if (!$app) {
    header('Location: admin_panel.php?error=Not found');
    exit();
}

$stmt = $pdo->prepare("SELECT language_id FROM application_languages WHERE application_id = ?");
$stmt->execute([$id]);
$selected = $stmt->fetchAll(PDO::FETCH_COLUMN);

$all_langs = $pdo->query("SELECT id, name FROM languages ORDER BY name")->fetchAll();

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
    if (empty($full_name)) $errors[] = 'Name required';
    if (empty($phone)) $errors[] = 'Phone required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    if (empty($birth_date)) $errors[] = 'Birth date required';
    if (!in_array($gender, ['male', 'female'])) $errors[] = 'Gender required';
    if (empty($biography)) $errors[] = 'Biography required';
    if (!$agreed) $errors[] = 'Must agree to contract';
    if (empty($languages)) $errors[] = 'Select at least one language';
    
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("UPDATE applications SET full_name=?, phone=?, email=?, birth_date=?, gender=?, biography=?, agreed=? WHERE id=?");
            $stmt->execute([$full_name, $phone, $email, $birth_date, $gender, $biography, $agreed, $id]);
            
            $stmt = $pdo->prepare("DELETE FROM application_languages WHERE application_id=?");
            $stmt->execute([$id]);
            
            $stmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
            foreach ($languages as $lid) {
                $stmt->execute([$id, $lid]);
            }
            
            $pdo->commit();
            $success = 'Saved successfully';
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'DB error: ' . $e->getMessage();
        }
    } else {
        $error = implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit #<?= $id ?></title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 600px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Edit Application #<?= $id ?></h1>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($app['full_name']) ?>" required>
        
        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($app['phone']) ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($app['email']) ?>" required>
        
        <label>Birth Date:</label>
        <input type="date" name="birth_date" value="<?= $app['birth_date'] ?>" required>
        
        <label>Gender:</label>
        <select name="gender">
            <option value="male" <?= $app['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $app['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
        </select>
        
        <label>Languages:</label>
        <select name="languages[]" multiple required>
            <?php foreach ($all_langs as $lang): ?>
                <option value="<?= $lang['id'] ?>" <?= in_array($lang['id'], $selected) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lang['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label>Biography:</label>
        <textarea name="biography" rows="5" required><?= htmlspecialchars($app['biography']) ?></textarea>
        
        <label>
            <input type="checkbox" name="agreed" value="1" <?= $app['agreed'] ? 'checked' : '' ?>>
            Agree to contract
        </label>
        
        <button type="submit">Save Changes</button>
    </form>
    <p><a href="admin_panel.php">← Back to panel</a></p>
</body>
</html>

