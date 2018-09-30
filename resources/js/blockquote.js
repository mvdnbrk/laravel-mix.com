let blockquotes = document.querySelectorAll('#content blockquote');

for (let b = 0; b < blockquotes.length; b++) {

    item = blockquotes[b]

    let str = item.innerText
    let match = str.match(/\{(.*?)\}/)

    if (match) {
        var icon = match[1] || false;
        var word = match[1] || false;
    }

    if (icon) {
        switch (icon) {
            case 'note':
              icon = '<svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/></svg>';
              break;
            case 'tip':
              icon = '<svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 13.33a7 7 0 1 1 6 0V16H7v-2.67zM7 17h6v1.5c0 .83-.67 1.5-1.5 1.5h-3A1.5 1.5 0 0 1 7 18.5V17zm2-5.1V14h2v-2.1a5 5 0 1 0-2 0z"/></svg>';
              break;
        }

        item.innerHTML = item.innerHTML.replace(/\{(.*?)\}/, '')

        let elem = document.createElement('div')
        elem.innerHTML = icon

        item.insertBefore(elem, item.firstChild)

        item.className = word
    }
}

