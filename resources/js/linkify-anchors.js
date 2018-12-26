import GithubSlugger from 'github-slugger'
import markyDeepLinks from 'marky-deep-links'

let slugger = new GithubSlugger()

let anchorForHeader = function (header) {
    let slug = slugger.slug(header.innerText)

    let anchor = document.createElement('a')

    anchor.className = 'header-link'
    anchor.id = 'user-content-' + slug
    anchor.href = '#' + slug
    anchor.setAttribute('aria-hidden', 'true')

    anchor.innerHTML = '<svg aria-hidden="true" class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"/></svg>'

    return anchor
};

let linkifyAnchors = function (level, element) {
    let headers = element.getElementsByTagName("h" + level)

    for (let h = 0; h < headers.length; h++) {
        let header = headers[h];
        header.className = '-ml-4'
        header.insertBefore(anchorForHeader(header), header.firstChild)
    }
};

document.onreadystatechange = function () {
    if (this.readyState === "interactive") {
        let contentBlock = document.getElementById('content')

        if (! contentBlock) {
            return
        }

        for (var level = 1; level <= 4; level++) {
            linkifyAnchors(level, contentBlock)
        }
    }

    markyDeepLinks()
}
