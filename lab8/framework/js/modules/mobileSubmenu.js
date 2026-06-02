import { $$ } from '../utils/dom.js';

export class MobileSubmenu {
    constructor() {
        this.submenuToggles = $$('.mobile-submenu-toggle');
        
        if (this.submenuToggles.length === 0) return;
        
        this.init();
    }
    
    init() {
        this.submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', () => this.toggle(toggle));
        });
    }
    
    toggle(clickedToggle) {
        const isExpanded = clickedToggle.getAttribute('aria-expanded') === 'true';
        
        this.submenuToggles.forEach(otherToggle => {
            if (otherToggle !== clickedToggle) {
                otherToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        clickedToggle.setAttribute('aria-expanded', !isExpanded);
    }
}