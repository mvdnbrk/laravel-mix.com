const mix = require('laravel-mix');

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
    .vue({ version: 3 })
    .extract([
        'vue',
        '@vue',
        'prismjs',
        'in-viewport',
        'github-slugger',
        'marky-deep-links',
    ])
    .postCss('resources/css/app.css', 'public/css', [
        require('@tailwindcss/postcss'),
    ])
    .options({
        // Tailwind CSS v4 takes care of vendor prefixing itself.
        autoprefixer: false,
    })
    .webpackConfig({
        resolve: {
            alias: {
                // The Vue templates live in the Blade views (in-DOM templates),
                // so we need the build that includes the template compiler.
                vue$: 'vue/dist/vue.esm-bundler.js',
            },
        },
    })
    .version();
