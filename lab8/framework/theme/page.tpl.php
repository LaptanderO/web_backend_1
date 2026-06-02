<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drupal-coder — поддержка и разработка на Drupal</title>
    <link rel="stylesheet" href="<?= conf('basedir') ?>/css/main.css">
</head>

<body>
    <!-- ==================== ЧАСТЬ 1: ГЕРОЙ ==================== -->
    <section class="hero" id="home">
        <div class="hero-video">
            <video autoplay muted loop playsinline>
                <source src="<?= conf('basedir') ?>/video/video.mp4" type="video/mp4">
                Ваш браузер не поддерживает видео.
            </video>
            <div class="video-fallback"></div>
        </div>

        <div class="hero-inner">
            <div class="hero-content">
                <h1 class="hero-title">Поддержка сайтов на Drupal</h1>
                <p class="hero-subtitle">
                    Сопровождение и поддержка сайтов<br>
                    на CMS Drupal любых версий и запущенности
                </p>
                <button class="hero-button" type="button">Тарифы</button>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">#1</h3></div>
                        <p class="feature-text">Drupal-разработчик в России по версии Рейтинга Рунета</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">3+</h3></div>
                        <p class="feature-text">средний опыт специалистов более 3 лет</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">14</h3></div>
                        <p class="feature-text">лет опыта в сфере Drupal</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">90000+</h3></div>
                        <p class="feature-text">часов поддержки сайтов на Drupal</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">300+</h3></div>
                        <p class="feature-text">Проектов на поддержке</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-header"><h3 class="feature-title">50+</h3></div>
                        <p class="feature-text">модулей и тем в формате DrupalGive</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bar">
            <div class="logo">
                <img src="<?= conf('basedir') ?>/img/drupal-coder.svg" alt="Логотип Drupal-coder">
            </div>
            <nav class="desktop-menu">
                <ul class="desktop-menu-list">
                    <li><a href="#home">Поддержка Drupal</a></li>
                    <li class="has-dropdown">
                        <a href="#administration">Администрирование</a>
                        <ul class="dropdown-menu">
                            <li><a href="#migration">Миграция</a></li>
                            <li><a href="#backups">Бэкапы</a></li>
                            <li><a href="#security">Аудит безопасности</a></li>
                            <li><a href="#optimization">Оптимизация скорости</a></li>
                            <li><a href="#https">Переезд на HTTPS</a></li>
                        </ul>
                    </li>
                    <li><a href="#promotion">Продвижение</a></li>
                    <li><a href="#advertising">Реклама</a></li>
                    <li class="has-dropdown">
                        <a href="#about">О нас</a>
                        <ul class="dropdown-menu">
                            <li><a href="#team">Команда</a></li>
                            <li><a href="#drupalgive">DRUPALGIVE</a></li>
                            <li><a href="#blog">Блог</a></li>
                            <li><a href="#courses">Курсы Drupal</a></li>
                        </ul>
                    </li>
                    <li><a href="#projects">Проекты</a></li>
                    <li><a href="#contact">Контакты</a></li>
                </ul>
            </nav>
            <button class="menu-toggle" id="menuToggle" aria-label="Открыть меню">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>
        </div>

        <nav class="mobile-menu" id="mobileMenu">
            <ul class="mobile-menu-list">
                <li><a href="#home">Поддержка Drupal</a></li>
                <li class="mobile-has-submenu">
                    <button class="mobile-submenu-toggle" aria-expanded="false">
                        Администрирование <span class="submenu-arrow">▾</span>
                    </button>
                    <ul class="mobile-submenu">
                        <li><a href="#migration">Миграция</a></li>
                        <li><a href="#backups">Бэкапы</a></li>
                        <li><a href="#security">Аудит безопасности</a></li>
                        <li><a href="#optimization">Оптимизация скорости</a></li>
                        <li><a href="#https">Переезд на HTTPS</a></li>
                    </ul>
                </li>
                <li><a href="#promotion">Продвижение</a></li>
                <li><a href="#advertising">Реклама</a></li>
                <li class="mobile-has-submenu">
                    <button class="mobile-submenu-toggle" aria-expanded="false">
                        О нас <span class="submenu-arrow">▾</span>
                    </button>
                    <ul class="mobile-submenu">
                        <li><a href="#team">Команда</a></li>
                        <li><a href="#drupalgive">DRUPALGIVE</a></li>
                        <li><a href="#blog">Блог</a></li>
                        <li><a href="#courses">Курсы Drupal</a></li>
                    </ul>
                </li>
                <li><a href="#projects">Проекты</a></li>
                <li><a href="#contact">Контакты</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-overlay" id="menuOverlay"></div>
    </section>

    <!-- ==================== ЧАСТЬ 2: О НАС ==================== -->
    <section class="about" id="about">
        <div class="about-container">
            <h2 class="about-title">13 лет совершенствуем компетенции в Drupal поддержке</h2>
            <div class="about-text">
                <p>Разрабатываем и оптимизируем модули, расширяем функциональность сайтов, обновляем дизайн</p>
            </div>
            <div class="about-grid">
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-1.svg" alt=""></div>
                    <p class="about-card-text">Добавление информации на сайт, создание новых разделов</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-2.svg" alt=""></div>
                    <p class="about-card-text">Интеграция с CRM, 1C, платежными системами, любыми веб-сервисами</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-3.svg" alt=""></div>
                    <p class="about-card-text">Аудит и мониторинг безопасности Drupal сайтов</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-4.svg" alt=""></div>
                    <p class="about-card-text">Оптимизация и ускорение Drupal-сайтов</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-5.svg" alt=""></div>
                    <p class="about-card-text">Разработка и оптимизация модулей сайта</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-6.svg" alt=""></div>
                    <p class="about-card-text">Любые доработки функционала и дизайна</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-7.svg" alt=""></div>
                    <p class="about-card-text">Миграция, импорт контента и апгрейд Drupal</p>
                </div>
                <div class="about-card">
                    <div class="about-card-image"><img src="<?= conf('basedir') ?>/img/competency-8.svg" alt=""></div>
                    <p class="about-card-text">Веб-маркетинг, консультации и работы по SEO</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 3: ПОДДЕРЖКА ==================== -->
    <section class="support">
        <div class="support-container">
            <h2 class="support-title">Поддержка от Drupal-coder</h2>
            <div class="support-grid">
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">01.</span>
                        <h3 class="support-card-title">Постановка задачи по Email</h3>
                        <p class="support-card-text">Удобная и привычная модель постановки задач, при которой задачи фиксируются и никогда не теряются.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support1.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">02.</span>
                        <h3 class="support-card-title">Система Helpdesk - отчетность, прозрачность</h3>
                        <p class="support-card-text">Возможность посмотреть все заявки в работе и отработанные часы в личном кабинете через браузер.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support2.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">03.</span>
                        <h3 class="support-card-title">Расширенная техническая поддержка</h3>
                        <p class="support-card-text">Возможность организации расширенной техподдержки с 6:00 до 22:00 без выходных.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support3.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">04.</span>
                        <h3 class="support-card-title">Персональный менеджер проекта</h3>
                        <p class="support-card-text">Ваш менеджер проекта всегда в курсе текущего состояния проекта.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support4.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">05.</span>
                        <h3 class="support-card-title">Удобные способы оплаты</h3>
                        <p class="support-card-text">Безналичный расчет или электронные деньги: WebMoney, Яндекс.Деньги, Paypal.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support5.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">06.</span>
                        <h3 class="support-card-title">Работаем с SLA и NDA</h3>
                        <p class="support-card-text">Работа в рамках соглашений о конфиденциальности и об уровне качества работ.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support6.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">07.</span>
                        <h3 class="support-card-title">Штатные специалисты</h3>
                        <p class="support-card-text">Надежные штатные специалисты, никаких фрилансеров.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support7.svg" alt=""></div>
                </article>
                <article class="support-card">
                    <div class="support-card-content">
                        <span class="support-card-number">08.</span>
                        <h3 class="support-card-title">Удобные каналы связи</h3>
                        <p class="support-card-text">Консультации по телефону, скайпу, в мессенджерах.</p>
                    </div>
                    <div class="support-card-image"><img src="<?= conf('basedir') ?>/img/support8.svg" alt=""></div>
                </article>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 4: ЭКСПЕРТИЗА ==================== -->
    <section class="expertise">
        <div class="expertise-container">
            <h2 class="expertise-title">Экспертиза в Drupal, опыт 14 лет!</h2>
            <div class="expertise-content">
                <div class="expertise-block">
                    <div class="expertise-text"><p>Только системный подход - контроль версий, резервирование и тестирование!</p></div>
                    <div class="expertise-line"></div>
                </div>
                <div class="expertise-block">
                    <div class="expertise-text"><p>Только Drupal сайты, не берем на поддержку сайты на других CMS!</p></div>
                    <div class="expertise-line"></div>
                </div>
                <div class="expertise-block">
                    <div class="expertise-text">
                        <p>Участвуем в разработке ядра Drupal и модулей на Drupal.org, разрабатываем
                            <a href="" target="_blank" class="expertise-link">свои модули Drupal</a></p>
                    </div>
                    <div class="expertise-line"></div>
                </div>
                <div class="expertise-block">
                    <div class="expertise-text"><p>Поддерживаем сайты на Drupal 5, 6, 7 и 8</p></div>
                    <div class="expertise-line"></div>
                </div>
            </div>
        </div>
        <img src="<?= conf('basedir') ?>/img/laptop.png" alt="" class="expertise-bg-image">
    </section>

    <!-- ==================== ЧАСТЬ 5: ТАРИФЫ ==================== -->
    <section class="tariffs" id="tariffs">
        <div class="tariffs-container">
            <h2 class="tariffs-title">Тарифы</h2>
            <div class="tariffs-grid">
                <article class="tariff-card">
                    <h3 class="tariff-card-title">Стартовый</h3>
                    <div class="tariff-card-text"><p>Консультации и работы по SEO, услуги дизайнера<br>Предоплата от 6 000 рублей в месяц</p></div>
                    <button class="tariff-card-button" type="button">Свяжитесь с нами!</button>
                </article>
                <article class="tariff-card">
                    <h3 class="tariff-card-title">Бизнес</h3>
                    <div class="tariff-card-text"><p>Консультации и работы по SEO, услуги дизайнера<br>Предоплата от 30 000 рублей в месяц</p></div>
                    <button class="tariff-card-button" type="button">Свяжитесь с нами!</button>
                </article>
                <article class="tariff-card">
                    <h3 class="tariff-card-title">VIP</h3>
                    <div class="tariff-card-text"><p>Максимальное время реакции – в день обращения<br>Предоплата от 270 000 рублей в месяц</p></div>
                    <button class="tariff-card-button" type="button">Свяжитесь с нами!</button>
                </article>
            </div>
            <div class="tariffs-after-text"><p>Вам не подходят наши тарифы? Оставьте заявку и мы предложим вам индивидуальные условия!</p></div>
            <div class="tariffs-individual"><a href="#individual" class="individual-link">получить индивидуальный тариф</a></div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 6: УСЛУГИ ==================== -->
    <section class="services">
        <div class="services-container">
            <h2 class="services-title">Наши профессиональные разработчики выполняют быстро любые задачи</h2>
            <div class="services-grid">
                <article class="service-card">
                    <div class="service-card-image"><img src="<?= conf('basedir') ?>/img/competency-20.svg" alt=""></div>
                    <h3 class="service-card-title">от 14ч</h3>
                    <div class="service-card-text"><p>Настройка события GA в интернет-магазине</p></div>
                </article>
                <article class="service-card">
                    <div class="service-card-image"><img src="<?= conf('basedir') ?>/img/competency-21.svg" alt=""></div>
                    <h3 class="service-card-title">от 20ч</h3>
                    <div class="service-card-text"><p>Разработка мобильной версии сайта</p></div>
                </article>
                <article class="service-card">
                    <div class="service-card-image"><img src="<?= conf('basedir') ?>/img/competency-22.svg" alt=""></div>
                    <h3 class="service-card-title">от 8ч</h3>
                    <div class="service-card-text"><p>Интеграция модуля оплаты</p></div>
                </article>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 8: КОМАНДА ==================== -->
    <section class="team">
        <div class="team-container">
            <h2 class="team-title">Команда</h2>
            <div class="team-grid">
                <article class="team-card">
                    <div class="team-card-image"><img src="<?= conf('basedir') ?>/img/IMG_2472_0.jpg" alt="Сергей Синица"></div>
                    <h3 class="team-card-name">Сергей Синица</h3>
                    <div class="team-card-text"><p>Руководитель отдела веб-разработки, канд. техн. наук, заместитель директора.</p></div>
                </article>
                <article class="team-card">
                    <div class="team-card-image"><img src="<?= conf('basedir') ?>/img/IMG_2539_0.jpg" alt="Роман Агабеков"></div>
                    <h3 class="team-card-name">Роман Агабеков</h3>
                    <div class="team-card-text"><p>Директор по DevOps, директор.</p></div>
                </article>
                <article class="team-card">
                    <div class="team-card-image"><img src="<?= conf('basedir') ?>/img/IMG_2474_1.jpg" alt="Алексей Синица"></div>
                    <h3 class="team-card-name">Алексей Синица</h3>
                    <div class="team-card-text"><p>Руководитель отдела поддержки сайтов.</p></div>
                </article>
                <article class="team-card">
                    <div class="team-card-image"><img src="<?= conf('basedir') ?>/img/IMG_2522_0.jpg" alt="Дарья Бочкарёва"></div>
                    <h3 class="team-card-name">Дарья Бочкарёва</h3>
                    <div class="team-card-text"><p>Руководитель отдела продвижения, контекстной рекламы, контент-поддержки сайтов.</p></div>
                </article>
                <article class="team-card">
                    <div class="team-card-image"><img src="<?= conf('basedir') ?>/img/IMG_9971_16.jpg" alt="Ирина Торкунова"></div>
                    <h3 class="team-card-name">Ирина Торкунова</h3>
                    <div class="team-card-text"><p>Менеджер по работе с клиентами.</p></div>
                </article>
            </div>
            <div class="team-button-container"><button class="team-button" type="button">Вся команда</button></div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 9: КЕЙСЫ ==================== -->
    <section class="cases">
        <div class="cases-container">
            <h2 class="cases-title">Последние кейсы</h2>
            <div class="cases-grid">
                <article class="case-card">
                    <div class="case-card-bg"><img src="<?= conf('basedir') ?>/img/case-1.jpg" alt=""></div>
                    <div class="case-card-content">
                        <h3 class="case-card-title">Настройка кэширования данных. Апгрейд сервера. Ускорение работы сайта в 30 раз!</h3>
                        <div class="case-card-date">04.05.2020</div>
                    </div>
                </article>
                <div class="case-description"><p>Благодаря скорости загрузки страниц сайта отказы и конверсии. Кейс ускорения.</p></div>
                <article class="case-card">
                    <div class="case-card-bg"><img src="<?= conf('basedir') ?>/img/case-2.jpg" alt=""></div>
                    <div class="case-card-content"><h3 class="case-card-title">Использование отчетов Ecommerce в Яндекс.Метрике</h3></div>
                </article>
                <article class="case-card">
                    <div class="case-card-bg"><img src="<?= conf('basedir') ?>/img/case-3.jpg" alt=""></div>
                    <div class="case-card-content">
                        <h3 class="case-card-title">Повышение конверсии страницы с формой заявки с применением AB тестирования.</h3>
                        <div class="case-card-date">24.01.2020</div>
                    </div>
                </article>
                <article class="case-card">
                    <div class="case-card-bg"><img src="<?= conf('basedir') ?>/img/case-4.jpg" alt=""></div>
                    <div class="case-card-content">
                        <h3 class="case-card-title">Drupal 7: ускорение времени генерации страницы интернет-магазина на 32%.</h3>
                        <div class="case-card-date">23.09.2019</div>
                    </div>
                </article>
                <article class="case-card">
                    <div class="case-card-bg"><img src="<?= conf('basedir') ?>/img/case-5.jpg" alt=""></div>
                    <div class="case-card-content">
                        <h3 class="case-card-title">Обмен товарами и заказами интернет-магазина на Drupal 7 с 1С.</h3>
                        <div class="case-card-date">22.08.2019</div>
                    </div>
                </article>
            </div>
            <div class="cases-footer"><p>Опубликован <a href="#release" class="release-link">релиз модуля</a></p></div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 10: ОТЗЫВЫ ==================== -->
    <section class="reviews">
        <div class="reviews-container">
            <h2 class="reviews-title">Отзывы</h2>
            <div class="reviews-slider">
                <div class="slider-wrapper">
                    <div class="review-slide active">
                        <div class="review-card">
                            <div class="review-logo"><img src="<?= conf('basedir') ?>/img/logo_0.png" alt=""></div>
                            <div class="review-text"><p>Долгие поиски единственного и неповторимого мастера... привели меня к ребятам из Drupal-coder. Все качественно и быстро!</p></div>
                            <div class="review-author">
                                <div class="author-info">
                                    <span class="author-name">Наталья Сушкова</span>
                                    <a href="http://www.cielparfum.com/" class="company-link" target="_blank">cielparfum.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-nav">
                    <button class="slider-arrow prev" aria-label="Предыдущий">←</button>
                    <div class="slider-counter"><span class="current-slide">01</span>/<span class="total-slides">08</span></div>
                    <button class="slider-arrow next" aria-label="Следующий">→</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 11: ПАРТНЁРЫ ==================== -->
    <section class="partners">
        <div class="partners-container">
            <h2 class="partners-title">С нами работают</h2>
            <div class="partners-text"><p>Десятки компаний доверяют нам самое ценное, что у них есть в Интернете – свои сайты.</p></div>
            <div class="partners-rows-container">
                <div class="partners-row">
                    <div class="partners-track">
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo_0.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo_2.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo-estee.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/lpcma_rus_v4.jpg" alt=""></div>
                    </div>
                </div>
                <div class="partners-row">
                    <div class="partners-track">
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/nashagazeta_ch.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo-estee.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo_2.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/logo_0.png" alt=""></div>
                        <div class="partner-logo"><img src="<?= conf('basedir') ?>/img/lpcma_rus_v4.jpg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 12: FAQ ==================== -->
    <section class="faq">
        <div class="faq-container">
            <h2 class="faq-title">FAQ</h2>
            <div class="faq-accordion">
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">01</span>
                        <span class="faq-question-text">Кто непосредственно занимается поддержкой?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Сайты поддерживают штатные сотрудники ООО «Инитлаб» г. Краснодар, прошедшие специальное
                            обучение и имеющие опыт работы с Drupal от 4 до 15 лет: 8 web-разработчиков, 2 специалиста
                            по SEO, 4 системных администратора.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">02</span>
                        <span class="faq-question-text">Как организована работа поддержки?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Работа поддержки организована в рамках выбранного тарифа, предоставляется определенное
                            количество часов для решения задач.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">03</span>
                        <span class="faq-question-text">Что происходит, когда отработаны все предоплаченные часы за
                            месяц?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Если все предусмотренные часы исчерпаны, дальнейшая работа осуществляется по дополнительному
                            соглашению.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">04</span>
                        <span class="faq-question-text">Что происходит, когда не отработаны все предоплаченные часы за
                            месяц?</span>
                    </button>
                    <div class="faq-answer">
                        <p>В зависимости от тарифа неиспользованные часы могут переноситься на следующий месяц или
                            сгорают.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">05</span>
                        <span class="faq-question-text">Как происходит оценка и согласование планируемого времени на
                            выполнение заявок?</span>
                    </button>
                    <div class="faq-answer">
                        <p>После получения заявки менеджер оценивает задачу и согласовывает с клиентом сроки и
                            стоимость.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">06</span>
                        <span class="faq-question-text">Сколько программистов выделяется на проект?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Количество специалистов зависит от сложности и объема задач проекта.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">07</span>
                        <span class="faq-question-text">Как подать заявку на внесение изменений на сайте?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Заявки подаются по электронной почте на support@drupal-coder.ru или через систему Helpdesk.
                        </p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">08</span>
                        <span class="faq-question-text">Как подать заявку на добавление пользователя, изменение настроек
                            веб-сервера и других задач по администрированию?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Через те же каналы связи: email или Helpdesk.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">09</span>
                        <span class="faq-question-text">В течение какого времени начинается работа по заявке?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Время начала работ зависит от выбранного тарифа: от момента обращения до 2 рабочих дней.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">10</span>
                        <span class="faq-question-text">В какое время работает поддержка?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Стандартная поддержка работает в рабочие часы. По тарифу "Максимум" доступна расширенная
                            поддержка с 6:00 до 22:00 без выходных.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">11</span>
                        <span class="faq-question-text">Подходят ли услуги поддержки, если необходимо произвести
                            обновление ядра Drupal или модулей?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Да, наши специалисты выполняют работы по обновлению и обеспечивают совместимость.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span class="faq-number">12</span>
                        <span class="faq-question-text">Можно ли пообщаться со специалистом голосом или в
                            мессенджере?</span>
                    </button>
                    <div class="faq-answer">
                        <p>Да, мы предоставляем консультации по телефону, Skype и в других мессенджерах по
                            договоренности.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== ЧАСТЬ 13: ФОРМА (ВСТАВЛЯЕТСЯ ФРЕЙМВОРКОМ) ==================== -->
    <?php foreach ($c['#content'] as $content) { echo $content; } ?>

    <script src="<?= conf('basedir') ?>/js/app.js" type="module"></script>
</body>
</html>