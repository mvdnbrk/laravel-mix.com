let mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.babelConfig({
    plugins: [
        ['prismjs', {
            'languages': ['bash', 'css', 'javascript', 'markup']
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
        'code',
        'pre',
        'blockquote',
        'carbon-ads',
        'lg:max-h-(screen-22)',
        'min-h-(screen-16)',
        'h1:hover .header-link',
        'h2:hover .header-link',
        'h3:hover .header-link',
        'h4:hover .header-link',
    ],
    whitelistPatterns: [/carbon.*/],
    whitelistPatternsChildren: [/^docs-index$/]
  })

if (mix.inProduction()) {
  mix.version()
}
