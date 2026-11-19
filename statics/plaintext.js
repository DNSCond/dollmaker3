// plaintext-log
class PlaintextLog extends HTMLScriptElement {
    connectedCallback() {
        console.info(this.text);
    }
}

customElements.define('plaintext-log', PlaintextLog, {extends: 'script'});
