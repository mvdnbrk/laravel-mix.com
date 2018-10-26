let mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.babelConfig({
    plugins: [
        ['prismjs', {
            'languages': ['bash', 'css', 'javascript', 'markup', 'php', 'sass', 'yaml']
        }]
    ]
});

mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css')
  .options({
    postCss: [
      require('postcss-import')(),
      require('tailwindcss')('./tailwind.js'),
      require('postcss-nesting')(),
    ]
  })
  .purgeCss({
    whitelist: [
        'h1',
        'h2',
        'h3',
        'h4',
        'li',
        'code',
        'pre',
        'blockquote',
        'lg:max-h-(screen-22)',
        'min-h-(screen-16)',
    ],
    whitelistPatterns: [/carbon.*/],
    whitelistPatternsChildren: [/^docs-index$/, /^token$/]
  })

if (mix.inProduction()) {
  mix.version()
}
