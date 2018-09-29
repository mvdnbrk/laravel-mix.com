import './toggle-menu'
import Prism from 'prismjs'

Prism.highlightAll()

// Highlights active link.
let current = document.querySelectorAll(".docs-index a[href='" + window.location.href + "']");
if (current.length) {
    current[0].classList.toggle('is-active');
}
