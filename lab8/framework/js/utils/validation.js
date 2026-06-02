/**
 * Валидация формы заявки (клиентская часть)
 * Правила совпадают с серверной валидацией в scripts/validation.php
 */

export function validateFooterForm(data) {
    const errors = {};

    // Имя
    if (!data.name || data.name.trim() === '') {
        errors.name = 'Введите имя';
    } else if (data.name.trim().length > 100) {
        errors.name = 'Имя слишком длинное (макс. 100 символов)';
    }

    // Телефон
    if (!data.phone || data.phone.trim() === '') {
        errors.phone = 'Введите телефон';
    } else if (!/^[\d\s\(\)\-\+]{7,20}$/.test(data.phone.trim())) {
        errors.phone = 'Неверный формат телефона';
    }

    // Email
    if (!data.email || data.email.trim() === '') {
        errors.email = 'Введите email';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email.trim())) {
        errors.email = 'Неверный формат email';
    }

    // Согласие
    if (!data.agreement) {
        errors.agreement = 'Требуется согласие на обработку данных';
    }

    // Капча
    if (!data.captcha) {
        errors.captcha = 'Подтвердите, что вы не робот';
    }

    return errors;
}