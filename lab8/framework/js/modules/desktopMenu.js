import { $$ } from '../utils/dom.js';

export class DesktopMenu {
    constructor() {
        this.dropdowns = $$('.has-dropdown');
        
        if (this.dropdowns.length === 0) return;
        
        this.init();
    }
    
    init() {
        this.dropdowns.forEach(dropdown => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            if (!dropdownMenu) return;
            
            dropdown.addEventListener('mouseenter', () => {
                dropdownMenu.style.opacity = '1';
                dropdownMenu.style.visibility = 'visible';
                dropdownMenu.style.transform = 'translateX(-50%) translateY(5px)';
            });
            
            dropdown.addEventListener('mouseleave', () => {
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.visibility = 'hidden';
                dropdownMenu.style.transform = 'translateX(-50%)';
            });
        });
    }
}