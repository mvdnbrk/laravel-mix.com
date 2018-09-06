let navOpen = document.getElementById('nav-open')
let navClose = document.getElementById('nav-close')
let nav = document.getElementById('nav')
let content = document.getElementById('content')

function toggleNav() {
    navOpen.classList.toggle('hidden')
    navClose.classList.toggle('hidden')
    nav.classList.toggle('hidden')
    content.classList.toggle('fixed')
}

navOpen.addEventListener('click', () => {
    toggleNav()
});

navClose.addEventListener('click', () => {
    toggleNav()
});
