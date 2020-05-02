const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: false,
    theme: {
        extend: {
            colors: {
                'digitalocean-blue': '#0080ff',
                'fathom-indigo': '#533feb',
                'ohdear-red': '#e32929',
                'ploi-blue': '#0e3283',
            },
            fontFamily: {
                fathom: [
                    '-apple-system',
                    'BlinkMacSystemFont',
                    '"San Francisco"',
                    '"Helvetica Neue"',
                    'Helvetica',
                    'Ubuntu',
                    'Roboto',
                    'Noto',
                    '"Segoe UI"',
                    'Arial',
                    'sans-serif',
                ],
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
