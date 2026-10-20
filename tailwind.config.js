/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Http/**/*.php",
  ],
  theme: {
    extend: {
      screens: {
        'xs': '480px',
      },
      colors: {
        // Brand accent — Ephamarcy logo orange (#F78A49 = 500)
        hospital: {
          50: '#fff6ef',
          100: '#feead9',
          200: '#fdd1b0',
          300: '#fbb17f',
          400: '#f99c61',
          500: '#f78a49',
          600: '#e8702c',
          700: '#c2561c',
          800: '#9a451a',
          900: '#7c3a19',
          950: '#431b0a',
        },
        // Brand primary — Ephamarcy logo navy (#153C63 = 800)
        navy: {
          50: '#f1f5fa',
          100: '#e1e9f3',
          200: '#c3d3e6',
          300: '#94b2d2',
          400: '#5f8ab8',
          500: '#3c6b9d',
          600: '#2a5583',
          700: '#1f466f',
          800: '#153c63',
          900: '#0f2c4a',
          950: '#091c31',
        },
        emergency: {
          50: '#fef2f2',
          100: '#fee2e2',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
        }
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
        heading: ['Outfit', 'Inter', 'sans-serif'],
      },
      boxShadow: {
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'card': '0 10px 25px -5px rgba(15, 29, 51, 0.05), 0 8px 10px -6px rgba(15, 29, 51, 0.03)',
      }
    },
  },
  plugins: [],
}
