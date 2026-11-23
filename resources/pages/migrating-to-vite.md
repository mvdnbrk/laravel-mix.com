# Migrating from Mix to Vite

-   [Introduction](#introduction)
-   [Install Vite](#install-vite)
-   [From webpack.mix.js to vite.config.js](#from-webpackmixjs-to-viteconfigjs)
-   [The Mix API in Vite](#the-mix-api-in-vite)
-   [Update Your JavaScript](#update-your-javascript)
-   [Update Your CSS](#update-your-css)
-   [Update Your Blade Templates](#update-your-blade-templates)
-   [Clean Up](#clean-up)
-   [Mix Extensions](#mix-extensions)
-   [Troubleshooting](#troubleshooting)

## Introduction

Laravel Mix is a legacy package that is no longer actively maintained. New Laravel applications use [Vite](https://laravel.com/docs/vite) instead.

This page is for Mix users. It shows what each part of a `webpack.mix.js` file becomes in Vite, and the errors you are most likely to run into. Use it together with the official [Laravel Mix to Vite migration guide](https://github.com/laravel/vite-plugin/blob/main/UPGRADE.md#migrating-from-laravel-mix-to-vite), which covers Inertia, SSR, Vapor and Sail.

The examples use Vite 8 and version 3 of the Laravel Vite plugin, which need Node.js 20.19 or 22.12 and newer. The `@vite` Blade directive needs Laravel 9.19 or newer.

## Install Vite

Remove Mix and the loaders it installed, then install Vite and the Laravel plugin:

```bash
npm remove laravel-mix resolve-url-loader sass-loader vue-loader ts-loader
npm install --save-dev vite laravel-vite-plugin
```

Install the plugin for your framework, if you use one:

```bash
npm install --save-dev @vitejs/plugin-vue
npm install --save-dev @vitejs/plugin-react
```

Vite only understands ES modules, so mark your project as one:

```bash
npm pkg set type=module
```

Any `.js` config file that still uses `require()` or `module.exports`, such as `tailwind.config.js` or `postcss.config.js`, must now either use `import` and `export default`, or be renamed to `.cjs`.

Replace the Mix scripts in `package.json`:

```js
"scripts": {
    "dev": "vite",
    "build": "vite build"
}
```

`npm run dev` replaces `npm run watch` and `npm run hot`. `npm run build` replaces `npm run production`.

## From webpack.mix.js to vite.config.js

Here is a typical Mix configuration:

```js
const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .ts('resources/js/admin.ts', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/print.css', 'public/css', [
        require('autoprefixer'),
    ])
    .alias({
        '@': path.join(__dirname, 'resources/js'),
    })
    .autoload({
        jquery: ['$', 'window.jQuery'],
    })
    .extract()
    .sourceMaps()
    .version();
```

And here is the same setup in a `vite.config.js` file in the root of your project:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/admin.ts',
                'resources/sass/app.scss',
                'resources/css/print.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        sourcemap: true,
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
```

A few things are different:

-   Every file you passed to `mix.js()`, `mix.ts()`, `mix.sass()` or `mix.postCss()` becomes an entry in `input`. There's no output path: Vite writes everything to `public/build`.
-   The `@` alias for `resources/js` is built into the Laravel plugin.
-   `.version()` is no longer needed. Vite always adds a hash to the file names.
-   `.extract()` is no longer needed. See [Code Splitting](#code-splitting) if you still want a separate vendor file.
-   `.autoload()` has no option in the config. See [Global jQuery](#global-jquery).
-   The `vue` alias is only needed if Vue compiles templates that are written in your Blade files. See [Vue Templates in Blade](#vue-templates-in-blade).

## The Mix API in Vite

| Mix | Vite |
| --- | --- |
| `mix.js()`, `mix.ts()` | An entry in the Laravel plugin's `input` |
| `.vue()` | `@vitejs/plugin-vue` |
| `.react()` | `@vitejs/plugin-react`, and files with JSX need a `.jsx` extension |
| `.preact()` | `@preact/preset-vite` |
| `mix.sass()`, `mix.less()`, `mix.stylus()` | An entry in `input`. Install `sass`, `less` or `stylus`; no loader is needed |
| `mix.postCss()` | An entry in `input`. PostCSS plugins go in `postcss.config.js` |
| `mix.copy()`, `mix.copyDirectory()` | See [Copying Files](#copying-files) |
| `mix.combine()`, `mix.scripts()`, `mix.styles()`, `mix.babel()`, `mix.minify()` | No equivalent. Import the files from an entry instead |
| `.version()` | Not needed. File names are always hashed |
| `.extract()` | Not needed. See [Code Splitting](#code-splitting) |
| `.sourceMaps()` | `build.sourcemap: true` |
| `.browserSync()` | `refresh: true` in the Laravel plugin, while `npm run dev` is running |
| `.alias()` | `resolve.alias` |
| `.autoload()` | See [Global jQuery](#global-jquery) |
| `.webpackConfig()`, `.override()` | No equivalent. Use Vite options or a Vite plugin |
| `.setPublicPath()` | `publicDirectory` and `buildDirectory` in the Laravel plugin |
| `.options({ processCssUrls: false })` | No option. See [URLs](#urls) |
| `.options({ terser: {} })` | `build.minify` |
| `mix()` in Blade | `@vite()` and `Vite::asset()` |
| `process.env.MIX_*` | `import.meta.env.VITE_*` |
| `mix-manifest.json` | `public/build/manifest.json` |
| `mix watch --hot` | `npm run dev` |

### Code Splitting

Mix needed `.extract()` and two extra script tags, `manifest.js` and `vendor.js`, to split your vendor code into its own file. Vite splits on dynamic `import()` by itself, and `@vite` adds `modulepreload` tags for every chunk an entry needs.

If you still want all of `node_modules` in a separate file, you can do that with the `codeSplitting` option of Rolldown, the bundler used by Vite 8:

```js
export default defineConfig({
    // ...
    build: {
        rolldownOptions: {
            output: {
                codeSplitting: {
                    groups: [
                        { name: 'vendor', test: /node_modules/ },
                    ],
                },
            },
        },
    },
});
```

You don't need to add a script tag for it. `@vite` loads it for you.

### Copying Files

Mix's `copy()` usually did one of three things. Each has its own replacement:

-   **Files you link to directly**, such as favicons or images in `public/images`: move them into `public/` and commit them. Vite never touches the `public/` directory.
-   **Images you want versioned**: add them to the Laravel plugin's `assets` option and reference them in Blade with `Vite::asset()`:

```js
laravel({
    input: ['resources/js/app.js'],
    assets: ['resources/images/**'],
}),
```

```html
<img src="{{ Vite::asset('resources/images/logo.svg') }}">
```

-   **Files from `node_modules`**: import them from your JavaScript or CSS if you can. If a file must be copied as is, use [vite-plugin-static-copy](https://www.npmjs.com/package/vite-plugin-static-copy). Its `dest` is relative to `public/build`:

```js
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        // ...
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/jquery/dist/jquery.min.js',
                    dest: 'vendor',
                    rename: { stripBase: true },
                },
            ],
        }),
    ],
});
```

This copies the file to `public/build/vendor/jquery.min.js` when you run `npm run build`. While `npm run dev` is running, the Vite dev server serves it instead.

## Update Your JavaScript

### Replace require() with import

This is the change most projects need, and the easiest one to miss. A `require()` call can still pass `npm run build`, but it breaks the page under `npm run dev` with:

```bash
Uncaught ReferenceError: require is not defined
```

Replace every `require()` with `import`. In the default Laravel `bootstrap.js` file, that looks like this:

```js
// Before
window._ = require('lodash');
window.axios = require('axios');

// After
import _ from 'lodash';
import axios from 'axios';

window._ = _;
window.axios = axios;
```

And in `app.js`:

```js
// Before
require('./bootstrap');

// After
import './bootstrap';
```

### Add the .vue Extension

Vite doesn't guess file extensions for Vue components:

```js
// Before
import Greeting from './components/Greeting';

// After
import Greeting from './components/Greeting.vue';
```

Without the extension, the build fails with `Could not load .../components/Greeting` and `No such file or directory`.

### Vue Templates in Blade

Many Mix projects mount Vue on a Blade page and use components directly in the HTML:

```html
<div id="app">
    <greeting></greeting>
</div>
```

That needs the Vue build that can compile templates in the browser. Mix used it by default. Vite uses the smaller runtime-only build, so your components silently don't render. During `npm run dev`, the console shows:

```bash
[Vue warn]: Component provided template option but runtime compilation is not supported in this build of Vue. Configure your bundler to alias "vue" to "vue/dist/vue.esm-bundler.js".
```

Add the alias from the warning to `vite.config.js`:

```js
resolve: {
    alias: {
        vue: 'vue/dist/vue.esm-bundler.js',
    },
},
```

You don't need this if all your templates live in `.vue` files.

### Global jQuery

Mix's `.autoload()` made `$` and `jQuery` available in every module. Without it, you get:

```bash
Uncaught ReferenceError: $ is not defined
```

Set the globals yourself in `bootstrap.js`, and import `bootstrap.js` before any code that uses them:

```js
import $ from 'jquery';

window.$ = window.jQuery = $;
```

### Environment Variables

Vite exposes `.env` variables that start with `VITE_`, through `import.meta.env`. Rename the variables in your `.env` file and in your code:

```bash
# Before
MIX_APP_NAME="${APP_NAME}"

# After
VITE_APP_NAME="${APP_NAME}"
```

```js
// Before
process.env.MIX_APP_NAME

// After
import.meta.env.VITE_APP_NAME
```

If you miss one, `npm run build` doesn't fail; the value is just `undefined`. Under `npm run dev`, you get `Uncaught ReferenceError: process is not defined`.

### TypeScript

Vite removes your types but doesn't check them, so a type error no longer stops the build. Run the TypeScript compiler yourself, for example in CI:

```bash
npx tsc --noEmit
```

## Update Your CSS

### URLs

Vite handles `url()` in CSS much like Mix did:

-   Relative URLs are resolved from the file they are written in, also inside Sass partials. The files are copied to `public/build/assets` with a hash in their name.
-   Absolute URLs, such as `url('/images/hero.png')`, are left alone in the build. They should point to a file in `public/`.

There's no equivalent of `processCssUrls: false`. Absolute URLs come closest, but they only work after `npm run build`. While `npm run dev` is running, your CSS comes from the Vite dev server, so the browser asks that server for `/images/hero.png`, and it doesn't serve your `public/` directory. Prefer relative URLs to files in `resources/`.

### PostCSS and Autoprefixer

PostCSS plugins move from `webpack.mix.js` to a `postcss.config.js` file, which Vite loads by itself:

```js
import autoprefixer from 'autoprefixer';

export default {
    plugins: [autoprefixer],
};
```

You may not need Autoprefixer anymore. When Vite minifies CSS for production, it adds the vendor prefixes your target browsers need.

### Import CSS From JavaScript

You can keep your stylesheets as separate entries, like in the example above. If you build a single-page app, you may also import the CSS from your JavaScript entry and only pass the JavaScript entry to `@vite`:

```js
import '../css/app.css';
```

## Update Your Blade Templates

Replace your `mix()` tags with a single `@vite` directive. Pass the same entries as in `vite.config.js`:

```html
<!-- Before -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

<!-- After -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
```

`@vite` loads your scripts with `type="module"`, so they are deferred. You can drop any `defer` attributes.

If you need the URL of a single built file, use `Vite::asset()`. It works for any entry and for the files in the `assets` option. This keeps a print stylesheet separate, for example:

```html
<link rel="stylesheet" href="{{ Vite::asset('resources/css/print.css') }}" media="print">
```

In your tests, replace `$this->withoutMix()` with `$this->withoutVite()`.

## Clean Up

-   Delete `webpack.mix.js`.
-   Delete the old Mix output: `public/mix-manifest.json`, and the files in `public/js` and `public/css` that Mix compiled.
-   Delete `public/hot` if it exists. See [Troubleshooting](#troubleshooting).
-   Add `/public/build` and `/public/hot` to your `.gitignore` file.

You don't need a clean step: Vite empties `public/build` before every build.

## Mix Extensions

Most Mix extensions have a Vite replacement, and some aren't needed anymore. These are the most popular ones:

| Mix extension | In Vite |
| --- | --- |
| [laravel-mix-polyfill](/extensions/polyfill) | No drop-in replacement. `@vitejs/plugin-legacy` builds legacy bundles, but `@vite` doesn't load them |
| [laravel-mix-merge-manifest](/extensions/merge-manifest) | Not needed. All entries share one `manifest.json` |
| [laravel-mix-purgecss](/extensions/purgecss) | Tailwind CSS removes unused classes itself. For other CSS, add `@fullhuman/postcss-purgecss` to `postcss.config.js` |
| [laravel-mix-eslint](/extensions/eslint) | Run `npx eslint` on its own, or use `vite-plugin-eslint2` |
| [laravel-mix-make-file-hash](/extensions/make-file-hash) | Not needed. Vite puts the hash in the file name |
| [laravel-mix-versionhash](/extensions/versionhash) | Not needed. Vite puts the hash in the file name |
| [laravel-mix-bundle-analyzer](/extensions/bundle-analyzer) | `rollup-plugin-visualizer` |
| [laravel-mix-tailwind](/extensions/tailwind), [mix-tailwindcss](/extensions/tailwindcss) | `@tailwindcss/vite` for Tailwind 4, or PostCSS for Tailwind 3 |
| [laravel-mix-copy-watched](/extensions/copy-watched) | See [Copying Files](#copying-files) |
| [laravel-mix-clean](/extensions/clean) | Not needed. Vite empties `public/build` before every build |
| [laravel-mix-glob](/extensions/glob) | `import.meta.glob()` |
| [mix-env-file](/extensions/env-file) | Vite's modes: `vite build --mode staging` also loads `.env.staging` |
| [laravel-mix-imagemin](/extensions/imagemin) | `vite-plugin-image-optimizer` |
| [laravel-mix-alias](/extensions/alias) | `resolve.alias` |
| [vuetifyjs-mix-extension](/extensions/vuetifyjs) | `vite-plugin-vuetify` |
| [laravel-mix-sri](/extensions/sri) | `vite-plugin-manifest-sri`. `@vite` adds the `integrity` attributes |
| [laravel-mix-svg-vue](/extensions/svg-vue) | `vite-svg-loader` |
| [laravel-mix-replace-in-file](/extensions/replace-in-file) | The `define` option |
| [laravel-mix-compress](/extensions/compress) | `vite-plugin-compression2` |

## Troubleshooting

**The page loads assets from `localhost:8080`.** Mix and Vite both use the `public/hot` file to find their dev server. If `mix watch --hot` didn't shut down cleanly, the old file is still there, and `@vite` tries to load your assets from the Mix dev server. Delete `public/hot`.

**Nothing changed after the migration.** Run `php artisan view:clear` to clear the compiled Blade views.

**Your Vue components don't render.** See [Vue Templates in Blade](#vue-templates-in-blade).

**`require is not defined`, `process is not defined` or `$ is not defined`.** See [Update Your JavaScript](#update-your-javascript).

For everything else, see the [Laravel Vite documentation](https://laravel.com/docs/vite).
