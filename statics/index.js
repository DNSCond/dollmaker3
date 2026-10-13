// AppleLockedUnblocked
export class AppleLockedUnblocked extends HTMLTemplateElement {
    connectedCallback() {
        this.content.querySelectorAll('character-display').forEach(each => {
            const id = each.querySelector('input').getAttribute('id'),
                unblocked = this.ownerDocument.getElementById(id + '-unblocked');
            unblocked.parentElement.parentElement.parentElement.replaceWith(each);
        });
    }
}

customElements.define('applelocked-unblocked', AppleLockedUnblocked, {extends: 'template'});