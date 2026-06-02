import { $$ } from '../utils/dom.js';

export class SmoothScroll {
    constructor() {
        this.anchors = $$('a[href^="#"]');
        this.heroButton = document.querySelector('.hero-button');
        this.tariffButtons = $$('.tariff-card-button');
        this.individualLink = document.querySelector('.individual-link');
        
        this.init();
    }
    
    init() {
        // Плавная прокрутка для всех якорных ссылок
        this.anchors.forEach(anchor => {
            anchor.addEventListener('click', (e) => this.handleAnchorClick(e, anchor));
        });
        
        // Кнопка "Тарифы"
        if (this.heroButton) {
            this.heroButton.addEventListener('click', () => {
                this.scrollToSection('.tariffs');
            });
        }
        
        // Кнопки в карточках тарифов
        this.tariffButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.scrollToSection('.footer-contact');
            });
        });
        
        // Ссылка "получить индивидуальный тариф"
        if (this.individualLink) {
            this.individualLink.addEventListener('click', (e) => {
                e.preventDefault();
                this.scrollToSection('.footer-contact');
                
                setTimeout(() => {
                    const nameInput = document.getElementById('footerName');
                    if (nameInput) nameInput.focus();
                }, 500);
            });
        }
    }
    
    handleAnchorClick(e, anchor) {
        e.preventDefault();
        
        const targetId = anchor.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            this.scrollTo(targetElement);
        }
    }
    
    scrollToSection(selector) {
        const section = document.querySelector(selector);
        if (section) {
            this.scrollTo(section);
        }
    }
    
    scrollTo(element) {
        window.scrollTo({
            top: element.offsetTop - 80,
            behavior: 'smooth'
        });
    }
}