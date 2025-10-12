import {InputChoicesElement, SelectChoicesElement} from "./elements/Choices";

import {clearAllBodyScrollLocks} from "body-scroll-lock";
import Lightbox from "./elements/Lightbox";
import AutomaticGallery from "./elements/AutomaticGallery";

Lightbox.defineElement();
AutomaticGallery.defineElement();

customElements.define('input-choices', InputChoicesElement, {
    extends: 'input',
});

customElements.define('select-choices', SelectChoicesElement, {
    extends: 'select',
});

clearAllBodyScrollLocks();