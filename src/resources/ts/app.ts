import {InputChoicesElement, SelectChoicesElement} from "./elements/Choices";

customElements.define('input-choices', InputChoicesElement, {
    extends: 'input',
});

customElements.define('select-choices', SelectChoicesElement, {
    extends: 'select',
});