<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'RezTax')</title>
        
        <!-- Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#13ec80",
                            "background-light": "#f6f8f7",
                            "background-dark": "#102219",
                            "surface-light": "#ffffff",
                            "surface-dark": "#1A2C23",
                            "text-main": "#111814",
                            "text-muted": "#618975",
                            "border-light": "#dbe6e0",
                            "border-dark": "#2A4034",
                        },
                        fontFamily: {
                            "display": ["Inter", "sans-serif"],
                            "sans": ["Inter", "sans-serif"]
                        },
                    },
                },
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        @yield('content')


    </body>
</html>