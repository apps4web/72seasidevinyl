/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './templates/Admin/**/*.php',
        './templates/layout/admin.php',
    ],
    theme: {
        extend: {
            colors: {
                primary:   '#3C50E0',
                secondary: '#80CAEE',
                'body-dark': '#1C2434',
                'sidebar':   '#1C2434',
                'sidebar-hover': '#333A48',
                'bodydark':  '#AEB7C0',
                'bodydark1': '#DEE4EE',
                'bodydark2': '#8A99AF',
                stroke:     '#E2E8F0',
                'gray-1':   '#F9FAFB',
                'gray-2':   '#F3F4F6',
                'gray-3':   '#E5E7EB',
                'gray-4':   '#6B7280',
                success:    '#219653',
                warning:    '#FFA70B',
                danger:     '#D34053',
                'danger-light': '#FFE8EA',
                'success-light': '#E1F4EB',
                'warning-light': '#FFF5D9',
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
