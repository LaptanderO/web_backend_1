export class CtaButtons {
    constructor() {
        this.ctaElements = [
            ...document.querySelectorAll('.hero-button'),
            ...document.querySelectorAll('.tariff-card-button'),
            ...document.querySelectorAll('.team-button'),
            ...document.querySelectorAll('.individual-link')
        ];
        
        this.init();
    }
    
    init() {
        this.ctaElements.forEach(element => {
            element.addEventListener('click', () => {
                console.log(`CTA клик: ${element.textContent.trim()}`);
                // В реальном проекте — отправка в Google Analytics
                // gtag('event', 'click', { event_category: 'CTA', event_label: element.textContent.trim() });
            });
        });
    }
}