let current = document.querySelectorAll(".docs-index a[href='" + window.location.href + "']");

if (current.length) {
    current[0].classList.toggle('is-active');
}
