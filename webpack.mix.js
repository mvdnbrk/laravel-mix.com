const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.babelConfig({
    plugins: [
        [
            'prismjs',
            {
                'languages': ['bash', 'css', 'diff', 'javascript', 'markup', 'php', 'sass', 'yaml']
            }
        ]
    ]
});

mix.js('resources/js/app.js', 'public/js')
    .extract([
        'vue',
        'prismjs',
        'in-viewport',
        'github-slugger',
        'marky-deep-links',
        'smoothscroll-for-websites',
    ])
    .postCss('resources/css/app.css', 'public/css')
    .options({
        postCss: [
            require('postcss-import')(),
            require('tailwindcss'),
        ]
    })
    .purgeCss({
        whitelist: [
            'h1',
            'h2',
            'h3',
            'h4',
            'li',
            'ul',
            'code',
            'pre',
            'table',
            'blockquote',
            'lg:max-h-(screen-22)',
            'min-h-(screen-16)',
        ],
        whitelistPatterns: [/carbon.*/],
        whitelistPatternsChildren: [/^docs-index$/, /^markdown-body$/, /^token$/]
    });

if (mix.inProduction()) {
    mix.version();
}
