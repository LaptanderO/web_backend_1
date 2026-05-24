<style>
<?php include 'theme/form_styles.css'; ?>
</style>

<div class="footer-contact">
    <div class="footer-contact-container">
        <h2 class="footer-contact-title">Оставить заявку на поддержку сайта</h2>
        
        <div id="js-credentials" style="display:none; background:#e8f5e9; padding:15px; border-radius:6px; margin-bottom:15px;"></div>
        <div id="js-errors" style="display:none; color:#ff6b6b; margin-bottom:15px;"></div>

        <?php if (!empty($c['messages'])): ?>
            <div style="background:#e8f5e9; padding:15px; border-radius:6px; margin-bottom:15px;">
                <?php foreach ($c['messages'] as $msg): ?>
                    <div><?= $msg ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="footer-form" id="footerForm" action="/" method="POST">
            <div class="form-row">
                <div class="form-group-footer">
                    <label for="footerName">Ваше имя *</label>
                    <input type="text" id="footerName" name="name" 
                           value="<?= htmlspecialchars($c['values']['name'] ?? '') ?>"
                           placeholder="Иван Иванов">
                    <?php if (!empty($c['errors']['name'])): ?>
                        <div style="color:#ff6b6b;"><?= $c['errors']['name'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group-footer">
                    <label for="footerPhone">Телефон *</label>
                    <input type="tel" id="footerPhone" name="phone" 
                           value="<?= htmlspecialchars($c['values']['phone'] ?? '') ?>"
                           placeholder="+7 (999) 123-45-67">
                    <?php if (!empty($c['errors']['phone'])): ?>
                        <div style="color:#ff6b6b;"><?= $c['errors']['phone'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group-footer full-width">
                <label for="footerEmail">E-mail *</label>
                <input type="email" id="footerEmail" name="email" 
                       value="<?= htmlspecialchars($c['values']['email'] ?? '') ?>"
                       placeholder="example@mail.ru">
                <?php if (!empty($c['errors']['email'])): ?>
                    <div style="color:#ff6b6b;"><?= $c['errors']['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group-footer full-width">
                <label for="footerComment">Ваш комментарий</label>
                <textarea id="footerComment" name="comment" rows="3" 
                          placeholder="Опишите вашу задачу..."><?= htmlspecialchars($c['values']['comment'] ?? '') ?></textarea>
            </div>
            <div class="form-agreement">
                <input type="checkbox" id="agreement" name="agreement" 
                       <?= !empty($c['values']['agreement']) ? 'checked' : '' ?>>
                <label for="agreement">Отправляя заявку, я даю согласие на обработку своих персональных данных.*</label>
                <?php if (!empty($c['errors']['agreement'])): ?>
                    <div style="color:#ff6b6b;"><?= $c['errors']['agreement'] ?></div>
                <?php endif; ?>
            </div>
            <div class="captcha-container">
                <input type="checkbox" id="captcha-v2" name="captcha">
                <span class="captcha-text">Я не робот</span>
            </div>
            <button type="submit" class="footer-submit-button" id="submitBtn">Свяжитесь с нами</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('footerForm');
    if (form) {
        form.addEventListener('submit', handleAjax);
    }
});

async function handleAjax(e) {
    e.preventDefault();
    
    var data = {
        name: document.getElementById('footerName').value.trim(),
        phone: document.getElementById('footerPhone').value.trim(),
        email: document.getElementById('footerEmail').value.trim(),
        comment: document.getElementById('footerComment').value.trim(),
        agreement: document.getElementById('agreement').checked,
        captcha: document.getElementById('captcha-v2').checked
    };
    
    var errors = {};
    if (!data.name) errors.name = 'Введите имя';
    if (!data.phone || !/^[\d\s\(\)\-\+]{7,20}$/.test(data.phone)) errors.phone = 'Неверный телефон';
    if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) errors.email = 'Неверный email';
    if (!data.agreement) errors.agreement = 'Требуется согласие';
    if (!data.captcha) errors.captcha = 'Подтвердите, что вы не робот';
    
    if (Object.keys(errors).length > 0) {
        showErrors(errors);
        return;
    }
    
    var btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.textContent = 'Отправка...';
    
    try {
        var resp = await fetch('/api/requests', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        
        var result = await resp.json();
        
        if (resp.ok) {
            document.getElementById('js-credentials').style.display = 'block';
            document.getElementById('js-credentials').innerHTML = 
                '✅ Заявка отправлена!<br>Логин: <strong>' + result.login + '</strong><br>Пароль: <strong>' + result.password + '</strong>';
            form.reset();
        } else {
            showErrors(result.errors || {server: 'Ошибка сервера'});
        }
    } catch (err) {
        showErrors({network: 'Ошибка сети'});
    } finally {
        btn.disabled = false;
        btn.textContent = 'Свяжитесь с нами';
    }
}

function showErrors(errors) {
    var el = document.getElementById('js-errors');
    el.style.display = 'block';
    el.innerHTML = Object.values(errors).map(function(e) { return '<div>⚠ ' + e + '</div>'; }).join('');
}
</script>

<noscript>
    <style>#js-errors, #js-credentials { display: none !important; }</style>
</noscript>