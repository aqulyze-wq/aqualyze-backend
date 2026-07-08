<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqualyze</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white p-6">

        <h1 class="text-2xl font-bold mb-8">
            🐟 Aqualyze
        </h1>

        <nav class="space-y-3">

            <a href="{{ route('dashboard') }}" class="block hover:bg-blue-600 p-2 rounded">
                Dashboard
            </a>

            <a href="{{ route('monitoring') }}" class="block hover:bg-blue-600 p-2 rounded">
                Monitoring
            </a>

            <a href="{{ route('charts') }}" class="block hover:bg-blue-600 p-2 rounded">
                Grafik
            </a>

            <a href="{{ route('profile.edit') }}" class="block hover:bg-blue-600 p-2 rounded">
                Profil
            </a>

        </nav>

    </aside>

    <!-- Content -->
    <main class="flex-1 p-8">

        @yield('content')

    </main>

</div>

</body>
</html>