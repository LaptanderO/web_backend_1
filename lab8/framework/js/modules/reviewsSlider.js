import { $, $$, addClass, removeClass, setAttr } from '../utils/dom.js';

export class ReviewsSlider {
    constructor() {
        this.slides = $$('.review-slide');
        this.prevButton = $('.slider-arrow.prev');
        this.nextButton = $('.slider-arrow.next');
        this.currentSlideSpan = $('.current-slide');
        this.totalSlidesSpan = $('.total-slides');
        this.slider = $('.reviews-slider');
        
        if (this.slides.length === 0) return;
        
        this.currentIndex = 0;
        this.totalSlides = this.slides.length;
        this.interval = null;
        
        this.init();
    }
    
    init() {
        this.totalSlidesSpan.textContent = this.totalSlides < 10 ? '0' + this.totalSlides : this.totalSlides;
        
        this.prevButton.addEventListener('click', () => {
            this.prev();
            this.resetInterval();
        });
        
        this.nextButton.addEventListener('click', () => {
            this.next();
            this.resetInterval();
        });
        
        this.slider.addEventListener('mouseenter', () => this.stopInterval());
        this.slider.addEventListener('mouseleave', () => this.startInterval());
        
        this.update();
        this.startInterval();
    }
    
    update() {
        this.slides.forEach(slide => {
            removeClass(slide, 'active');
            slide.style.opacity = '0';
        });
        
        addClass(this.slides[this.currentIndex], 'active');
        this.slides[this.currentIndex].style.opacity = '1';
        
        const displayIndex = this.currentIndex + 1;
        this.currentSlideSpan.textContent = displayIndex < 10 ? '0' + displayIndex : displayIndex;
    }
    
    next() {
        this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
        this.update();
    }
    
    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
        this.update();
    }
    
    startInterval() {
        this.interval = setInterval(() => this.next(), 10000);
    }
    
    stopInterval() {
        clearInterval(this.interval);
    }
    
    resetInterval() {
        this.stopInterval();
        this.startInterval();
    }
}