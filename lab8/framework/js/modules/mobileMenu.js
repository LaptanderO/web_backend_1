import { $, $$, addClass, removeClass, hasClass, setAttr } from '../utils/dom.js';

export class MobileMenu {
    constructor() {
        this.menuToggle = $('#menuToggle');
        this.mobileMenu = $('#mobileMenu');
        this.menuOverlay = $('#menuOverlay');
        this.menuLinks = $$('.mobile-menu-list a');
        this.body = document.body;
        
        if (!this.menuToggle || !this.mobileMenu) return;
        
        this.init();
    }
    
    init() {
        this.menuToggle.addEventListener('click', () => this.toggle());
        this.menuOverlay.addEventListener('click', () => this.close());
        this.menuLinks.forEach(link => {
            link.addEventListener('click', () => this.close());
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) this.close();
        });
    }
    
    isOpen() {
        return hasClass(this.mobileMenu, 'active');
    }
    
    toggle() {
        this.isOpen() ? this.close() : this.open();
    }
    
    open() {
        addClass(this.mobileMenu, 'active');
        addClass(this.menuOverlay, 'active');
        addClass(this.menuToggle, 'active');
        this.body.style.overflow = 'hidden';
        setAttr(this.menuToggle, 'aria-expanded', 'true');
    }
    
    close() {
        removeClass(this.mobileMenu, 'active');
        removeClass(this.menuOverlay, 'active');
        removeClass(this.menuToggle, 'active');
        this.body.style.overflow = '';
        setAttr(this.menuToggle, 'aria-expanded', 'false');
    }
}