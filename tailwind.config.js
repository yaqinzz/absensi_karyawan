import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "on-secondary-container": "#00714d",
                "surface-bright": "#f8f9ff",
                "error-container": "#ffdad6",
                "secondary": "#006c49",
                "on-tertiary-container": "#ffa929",
                "outline-variant": "#c4c5d5",
                "on-secondary-fixed": "#002113",
                "on-surface-variant": "#444653",
                "tertiary-container": "#6b4200",
                "primary-container": "#1e40af",
                "on-error-container": "#93000a",
                "outline": "#757684",
                "surface-container": "#e5eeff",
                "on-secondary-fixed-variant": "#005236",
                "background": "#f8f9ff",
                "inverse-surface": "#213145",
                "on-primary-fixed": "#001453",
                "on-error": "#ffffff",
                "surface-variant": "#d3e4fe",
                "on-tertiary-fixed": "#2a1700",
                "tertiary": "#4c2e00",
                "on-secondary": "#ffffff",
                "surface-container-low": "#eff4ff",
                "secondary-fixed-dim": "#4edea3",
                "on-primary-fixed-variant": "#173bab",
                "on-primary-container": "#a8b8ff",
                "primary-fixed": "#dde1ff",
                "surface-dim": "#cbdbf5",
                "surface-container-high": "#dce9ff",
                "primary-fixed-dim": "#b8c4ff",
                "inverse-on-surface": "#eaf1ff",
                "tertiary-fixed": "#ffddb8",
                "inverse-primary": "#b8c4ff",
                "on-primary": "#ffffff",
                "on-tertiary": "#ffffff",
                "surface": "#f8f9ff",
                "on-background": "#0b1c30",
                "surface-container-highest": "#d3e4fe",
                "on-surface": "#0b1c30",
                "secondary-container": "#6cf8bb",
                "primary": "#00288e",
                "surface-tint": "#3755c3",
                "error": "#ba1a1a",
                "secondary-fixed": "#6ffbbe",
                "tertiary-fixed-dim": "#ffb95f",
                "on-tertiary-fixed-variant": "#653e00",
                "surface-container-lowest": "#ffffff"
            },
            borderRadius: {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            spacing: {
                "sidebar-width": "260px",
                "xl": "32px",
                "md": "16px",
                "base": "4px",
                "gutter": "16px",
                "lg": "24px",
                "container-margin": "24px",
                "sm": "8px",
                "xs": "4px"
            },
            fontFamily: {
                "body-lg": ["Inter", ...defaultTheme.fontFamily.sans],
                "h2": ["Inter", ...defaultTheme.fontFamily.sans],
                "h1": ["Inter", ...defaultTheme.fontFamily.sans],
                "label-caps": ["Inter", ...defaultTheme.fontFamily.sans],
                "body-md": ["Inter", ...defaultTheme.fontFamily.sans],
                "h3": ["Inter", ...defaultTheme.fontFamily.sans],
                "data-table": ["Inter", ...defaultTheme.fontFamily.sans],
                "sans": ["Inter", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                "body-lg": ["16px", {"lineHeight": "1.6", "letterSpacing": "0em", "fontWeight": "400"}],
                "h2": ["24px", {"lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                "h1": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "label-caps": ["11px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                "body-md": ["14px", {"lineHeight": "1.5", "letterSpacing": "0em", "fontWeight": "400"}],
                "h3": ["18px", {"lineHeight": "1.4", "letterSpacing": "0em", "fontWeight": "600"}],
                "data-table": ["13px", {"lineHeight": "1.4", "letterSpacing": "0.01em", "fontWeight": "400"}]
            }
        },
    },

    plugins: [forms],
};
