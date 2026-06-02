import { $$ } from '../utils/dom.js';

export class PartnersAnimation {
    constructor() {
        this.rows = $$('.partners-row');
        
        if (this.rows.length === 0) return;
    }
}