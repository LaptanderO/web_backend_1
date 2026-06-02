<div class="container" style="max-width:400px; margin:50px auto;">
    <h1>Вход</h1>
    <?php if (!empty($c['error'])): ?>
        <div style="color:red; padding:10px; background:#fee; border-radius:6px; margin-bottom:15px;"><?= $c['error'] ?></div>
    <?php endif; ?>
    <form action="<?= conf('basedir') ?>/login" method="POST">
        <label>Логин:</label><br>
        <input type="text" name="login" required style="width:100%; padding:10px; margin-bottom:15px; border-radius:6px; border:1px solid #ddd;"><br>
        <label>Пароль:</label><br>
        <input type="password" name="password" required style="width:100%; padding:10px; margin-bottom:15px; border-radius:6px; border:1px solid #ddd;"><br>
        <button type="submit" style="width:100%; padding:12px; background:#FF6B35; color:#fff; border:none; border-radius:6px; font-size:16px; cursor:pointer;">Войти</button>
    </form>
    <p style="text-align:center; margin-top:15px;"><a href="<?= conf('basedir') ?>/">← Вернуться к форме</a></p>
</div>