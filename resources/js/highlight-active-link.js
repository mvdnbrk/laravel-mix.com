let current = document.querySelectorAll(".docs-index a[href='" + window.location.pathname + "']");

if (current.length) {
    current[0].classList.toggle('is-active');
}
