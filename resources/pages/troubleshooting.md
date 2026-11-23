# Troubleshooting Laravel Mix 6

-   [Why Builds Break Without Changes](#why-builds-break-without-changes)
-   [Cannot Find Module SizeFormatHelpers](#cannot-find-module-sizeformathelpers)
-   [Progress Plugin Invalid Options Object](#progress-plugin-invalid-options-object)
-   [Pin the webpack Version](#pin-the-webpack-version)
-   [Additional Dependencies Must Be Installed](#additional-dependencies-must-be-installed)
-   [Require Is Not Defined in ES Module Scope](#require-is-not-defined-in-es-module-scope)
-   [Tailwind CSS v4](#tailwind-css-v4)
-   [Node Sass Fails to Install](#node-sass-fails-to-install)
-   [Digital Envelope Routines Unsupported](#digital-envelope-routines-unsupported)
-   [Tested Versions](#tested-versions)

This page covers errors you may run into when you install or build a Laravel Mix 6 project with current versions of Node, npm and webpack, and how to fix them.

## Why Builds Break Without Changes

Laravel Mix 6.0.49, released in June 2022, is the final release. Mix accepts a range of versions for its dependencies, such as any webpack 5 from 5.60.0 up. When you install without a lockfile, run `npm update`, or delete `package-lock.json`, npm installs the newest versions in that range. Some of those newer versions no longer work with Mix.

If a project builds on one machine but not on another, compare the installed webpack versions:

```bash
npm ls webpack
```

## Cannot Find Module SizeFormatHelpers

```text
[webpack-cli] Error: Cannot find module 'webpack/lib/SizeFormatHelpers'
Require stack:
- node_modules/laravel-mix/src/webpackPlugins/BuildOutputPlugin.js
- node_modules/laravel-mix/src/builder/webpack-plugins.js
- node_modules/laravel-mix/src/builder/WebpackConfig.js
- node_modules/laravel-mix/src/Mix.js
- node_modules/laravel-mix/setup/webpack.config.js
```

webpack 5.107.0 removed the internal file `webpack/lib/SizeFormatHelpers`, which Mix uses to print the table of compiled files. Every new install of Mix 6 gets a newer webpack than that, so it fails with this error.

To fix it, [pin webpack to 5.105.4](#pin-the-webpack-version).

## Progress Plugin Invalid Options Object

```text
[webpack-cli] Invalid options object. Progress Plugin has been initialized using an options object that does not match the API schema.
 - options should be one of these:
   object { activeModules?, dependencies?, dependenciesCount?, entries?, handler?, modules?, modulesCount?, percentBy?, profile? } | function
   Details:
    * options has an unknown property 'name'. These properties are valid:
```

Starting with webpack 5.106.0, webpack checks the options of its progress plugin. Mix shows build progress with webpackbar 5, which passes options that webpack no longer accepts.

You will also see this error if you pinned webpack to 5.106 to get rid of the `SizeFormatHelpers` error. To fix both, [pin webpack to 5.105.4](#pin-the-webpack-version).

## Pin the webpack Version

webpack 5.105.4 is the newest version that works with Mix 6 as it is. Add an override to your `package.json` file:

```js
// npm
"overrides": {
    "webpack": "5.105.4"
}

// Yarn
"resolutions": {
    "webpack": "5.105.4"
}

// pnpm
"pnpm": {
    "overrides": {
        "webpack": "5.105.4"
    }
}
```

Then install again, and check that only webpack 5.105.4 is installed:

```bash
npm install
npm ls webpack
```

If your `package.json` file lists `webpack` under `devDependencies` itself, npm refuses the override:

```text
npm error code EOVERRIDE
npm error Override for webpack@^5.60.0 conflicts with direct dependency
```

In that case, set the version there instead, and leave out the override:

```js
"devDependencies": {
    "laravel-mix": "^6.0.49",
    "webpack": "5.105.4"
}
```

### Using webpack 5.106

If you need webpack 5.106, you can use it together with webpackbar 7, which no longer uses the webpack progress plugin. webpack 5.107 and newer still won't work.

```js
"overrides": {
    "webpack": "5.106.2",
    "webpackbar": "^7.0.0"
}
```

## Additional Dependencies Must Be Installed

```text
Additional dependencies must be installed. This will only take a moment.

Running: npm install sass-loader@^12.1.0 sass resolve-url-loader@^5.0.0 --save-dev --legacy-peer-deps

Finished. Please run Mix again.
```

The first time you use a feature such as `mix.sass()` or `mix.vue()`, Mix installs the packages it needs, adds them to your `package.json` file and stops. Run Mix again and it builds as usual.

Because Mix stops with an error, this fails a build on a CI or deploy server. Run Mix once on your own machine and commit the updated `package.json` and lockfile, or install the packages yourself:

```bash
# mix.sass()
npm install sass-loader@^12.1.0 sass resolve-url-loader@^5.0.0 --save-dev

# mix.vue() with Vue 3
npm install vue-loader@^16.2.0 --save-dev

# mix.vue() with Vue 2
npm install vue-template-compiler vue-loader@^15.9.8 --save-dev
```

## Require Is Not Defined in ES Module Scope

```text
[webpack-cli] ReferenceError: require is not defined in ES module scope, you can use import instead
This file is being treated as an ES module because it has a '.js' file extension and '/path/to/your-app/package.json' contains "type": "module". To treat it as a CommonJS script, rename it to use the '.cjs' file extension.
```

New Laravel applications set `"type": "module"` in `package.json`, which makes Node treat `webpack.mix.js` as an ES module. Use one of these fixes:

-   Rename `webpack.mix.js` to `webpack.mix.cjs`. Mix picks up `webpack.mix.cjs` automatically.
-   Use `import` instead of `require` at the top of `webpack.mix.js`:

```js
import mix from 'laravel-mix';

mix.js('resources/js/app.js', 'public/js');
```

## Tailwind CSS v4

```text
Error: It looks like you're trying to use `tailwindcss` directly as a PostCSS plugin. The PostCSS plugin has moved to a separate package, so to continue using Tailwind CSS with PostCSS you'll need to install `@tailwindcss/postcss` and update your PostCSS configuration.
```

In Tailwind CSS v4, the PostCSS plugin is a separate package. Install it:

```bash
npm install tailwindcss @tailwindcss/postcss --save-dev
```

Then use it in your `webpack.mix.js` file:

```js
mix.postCss('resources/css/app.css', 'public/css', [
    require('@tailwindcss/postcss'),
]);
```

And import Tailwind in your CSS file:

```css
@import 'tailwindcss';
```

## Node Sass Fails to Install

```text
npm warn deprecated node-sass@4.14.1: Node Sass is no longer supported. Please use `sass` or `sass-embedded` instead.
npm error command sh -c node scripts/build.js
npm error gyp ERR! configure error
```

Older projects may still list `node-sass` in `package.json`. Node Sass is no longer maintained and has no prebuilt binaries for current Node versions, so npm tries to compile it and fails. Mix 6 uses Dart Sass (the `sass` package), so replace Node Sass with it:

```bash
npm uninstall node-sass
npm install sass --save-dev
```

## Digital Envelope Routines Unsupported

```text
Error: error:0308010C:digital envelope routines::unsupported
  library: 'digital envelope routines',
  reason: 'unsupported',
  code: 'ERR_OSSL_EVP_UNSUPPORTED'
```

This error comes from Mix 5 and older, which use webpack 4. webpack 4 before 4.47.0 uses a hash algorithm that Node 17 and newer no longer support. It does not happen with Mix 6.

Update webpack 4 to 4.47.0, which fixes this:

```bash
npm update webpack
```

Or, better, [upgrade to Mix 6](/docs/6.0/upgrade). If neither is possible right now, you may run the build with the legacy OpenSSL provider as a workaround:

```bash
NODE_OPTIONS=--openssl-legacy-provider npm run production
```

## Tested Versions

Laravel Mix 6.0.49 with webpack 5.105.4, webpack-cli 4.10.0 and webpackbar 5.0.2 builds JavaScript, PostCSS, Sass and Vue files on:

| Tool    | Versions                                             |
| ------- | ---------------------------------------------------- |
| Node    | 18.20.8, 20.20.2, 22.20.0, 24.22.3, 25.9.0, 26.13.1 |
| npm     | 11.21.1                                              |
| Yarn    | 1.22.22                                              |
| pnpm    | 10.34.9                                              |
