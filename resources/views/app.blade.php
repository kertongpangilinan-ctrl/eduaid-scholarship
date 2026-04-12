<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        @auth
        <script>
            // Prevent back button navigation for authenticated users
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
                // Redirect based on user role
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    window.location.href = '/admin/dashboard';
                @else
                    window.location.href = '/dashboard';
                @endif
            };
        </script>
        @endauth
    </body>
</html>
