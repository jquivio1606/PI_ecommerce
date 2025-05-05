/** @type {import('tailwindcss').Config} */
export default {
    content: [
      './resources/**/*.blade.php', // Vistas de Blade
      './resources/**/*.js',        // Archivos JS
      './vendor/livewire/flux/**/*.blade.php' // Vistas de Flux
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  }
