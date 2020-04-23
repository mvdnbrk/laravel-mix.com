const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            colors: {
                'ploi-blue': '#0e3283',
                'digitalocean-blue': '#0080FF',
            },
            fontFamily: {
                helvetica: ['"Helvetica Neue"', 'Helvetica', 'system-ui', '-apple-system', 'BlinkMacSystemFont'],
            },
            minHeight: {
                '(screen-16)': 'calc(100vh - 4rem)',
            },
            maxHeight: {
                '(screen-22)': 'calc(100vh - 5.5rem)',
            },
            maxWidth: {
                'screen-xl': defaultTheme.screens.xl,
            },
        },
    },
    variants: {},
    plugins: [],
};
