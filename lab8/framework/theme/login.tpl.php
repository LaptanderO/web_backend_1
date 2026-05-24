<div class="container" style="max-width:400px; margin:50px auto;">
    <h1>Вход</h1>
    <?php if (!empty($c['error'])): ?>
        <div style="color:red;"><?= $c['error'] ?></div>
    <?php endif; ?>
    <form action="/login" method="POST">
        <label>Логин: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <button type="submit">Войти</button>
    </form>
</div>