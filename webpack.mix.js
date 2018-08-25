let mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.postCss('resources/css/app.css', 'public/css')
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
    ],
    whitelistPatterns: [/carbon.*/],
    whitelistPatternsChildren: [/^docs-index$/]
  })

if (mix.inProduction()) {
  mix.version()
}
