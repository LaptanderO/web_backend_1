/**
 * Drupal-coder — точка входа
 * Инициализация всех модулей
 */
import { MobileMenu } from './modules/mobileMenu.js';
import { MobileSubmenu } from './modules/mobileSubmenu.js';
import { DesktopMenu } from './modules/desktopMenu.js';
import { ReviewsSlider } from './modules/reviewsSlider.js';
import { FaqAccordion } from './modules/faqAccordion.js';
import { FooterForm } from './modules/footerForm.js';
import { PartnersAnimation } from './modules/partnersAnimation.js';
import { SmoothScroll } from './modules/smoothScroll.js';
import { CtaButtons } from './modules/ctaButtons.js';

document.addEventListener('DOMContentLoaded', () => {
    new MobileMenu();
    new MobileSubmenu();
    new DesktopMenu();
    new ReviewsSlider();
    new FaqAccordion();
    new FooterForm();
    new PartnersAnimation();
    new SmoothScroll();
    new CtaButtons();
    
    document.documentElement.classList.add('js-enabled');
    
    console.log('Drupal-coder: все модули инициализированы');
});