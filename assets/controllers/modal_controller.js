import { Controller } from '@hotwired/stimulus';
export default class extends Controller {
    static targets = ['dialog'];
    open() {
        this.dialogTarget.showModal();
        document.body.classList.add('overflow-hidden','opacity-50');
    }

    close() {
        this.dialogTarget.close();
        document.body.classList.remove('overflow-hidden','opacity-50');
    }

    clickOutside(event) {
        if (event.target === this.dialogTarget) {
            this.dialogTarget.close();
        }
    }
}
