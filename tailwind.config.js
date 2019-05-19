const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            minHeight: {
                '(screen-16)': 'calc(100vh - 4rem)',
            },
            maxHeight: {
                '(screen-22)': 'calc(100vh - 5.5rem)',
            },
            maxWidth : {
                'screen-xl': defaultTheme.screens.xl,
            }
        }
    },
    variants: {},
    plugins: []
}
