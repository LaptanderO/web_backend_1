import { $$, addClass, removeClass, hasClass, setAttr } from '../utils/dom.js';

export class FaqAccordion {
    constructor() {
        this.questions = $$('.faq-question');
        
        if (this.questions.length === 0) return;
        
        this.init();
    }
    
    init() {
        this.questions.forEach(question => {
            question.addEventListener('click', () => this.toggle(question));
        });
    }
    
    toggle(clickedQuestion) {
        const faqItem = clickedQuestion.parentElement;
        const isCurrentlyActive = hasClass(faqItem, 'active');
        const answer = clickedQuestion.nextElementSibling;
        
        // Закрываем все остальные
        this.questions.forEach(question => {
            const item = question.parentElement;
            const otherAnswer = question.nextElementSibling;
            
            if (item !== faqItem) {
                removeClass(item, 'active');
                setAttr(question, 'aria-expanded', 'false');
                otherAnswer.style.maxHeight = null;
            }
        });
        
        // Переключаем текущий
        if (!isCurrentlyActive) {
            addClass(faqItem, 'active');
            setAttr(clickedQuestion, 'aria-expanded', 'true');
            answer.style.maxHeight = answer.scrollHeight + 'px';
        } else {
            removeClass(faqItem, 'active');
            setAttr(clickedQuestion, 'aria-expanded', 'false');
            answer.style.maxHeight = null;
        }
    }
}