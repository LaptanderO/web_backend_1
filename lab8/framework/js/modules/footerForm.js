import { $, $$ } from '../utils/dom.js';
import { validateFooterForm } from '../utils/validation.js';

export class FooterForm {
    constructor() {
        this.form = document.getElementById('footerForm');
        if (!this.form) return;

        this.submitBtn = document.getElementById('submitBtn');
        this.errorsContainer = document.getElementById('js-errors');
        this.credentialsContainer = document.getElementById('js-credentials');

        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    async handleSubmit(e) {
        e.preventDefault();

        const data = {
            name: document.getElementById('footerName').value.trim(),
            phone: document.getElementById('footerPhone').value.trim(),
            email: document.getElementById('footerEmail').value.trim(),
            comment: document.getElementById('footerComment').value.trim(),
            agreement: document.getElementById('agreement').checked,
            captcha: document.getElementById('captcha-v2').checked
        };

        // Клиентская валидация
        const errors = validateFooterForm(data);
        if (Object.keys(errors).length > 0) {
            this.showErrors(errors);
            return;
        }

        // Блокируем кнопку
        this.submitBtn.disabled = true;
        this.submitBtn.textContent = 'Отправка...';

        try {
            const resp = await fetch('/web_backend_1/lab8/framework/api/requests', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await resp.json();

            if (resp.ok) {
                this.showCredentials(result.login, result.password);
                this.form.reset();
                this.hideErrors();
            } else {
                this.showErrors(result.errors || { server: 'Ошибка сервера' });
            }
        } catch (err) {
            this.showErrors({ network: 'Ошибка сети. Проверьте подключение.' });
        } finally {
            this.submitBtn.disabled = false;
            this.submitBtn.textContent = 'Свяжитесь с нами';
        }
    }

    showErrors(errors) {
        if (!this.errorsContainer) {
            this.errorsContainer = document.createElement('div');
            this.errorsContainer.id = 'js-errors';
            this.errorsContainer.className = 'js-errors';
            this.form.parentNode.insertBefore(this.errorsContainer, this.form);
        }
        this.errorsContainer.style.display = 'block';
        this.errorsContainer.innerHTML = Object.values(errors)
            .map(e => `<div>⚠ ${e}</div>`)
            .join('');

        setTimeout(() => {
            this.errorsContainer.style.display = 'none';
        }, 5000);
    }

    hideErrors() {
        if (this.errorsContainer) {
            this.errorsContainer.style.display = 'none';
        }
    }

    showCredentials(login, password) {
        if (!this.credentialsContainer) {
            this.credentialsContainer = document.createElement('div');
            this.credentialsContainer.id = 'js-credentials';
            this.credentialsContainer.className = 'js-messages';
            this.form.parentNode.insertBefore(this.credentialsContainer, this.form);
        }
        this.credentialsContainer.style.display = 'block';
        this.credentialsContainer.innerHTML = `
            ✅ Заявка отправлена!<br>
            Ваш логин: <strong>${login}</strong><br>
            Ваш пароль: <strong>${password}</strong><br>
            <a href="/web_backend_1/lab8/framework/login" style="color:#2e7d32;">Войти для редактирования</a>
        `;
    }
}