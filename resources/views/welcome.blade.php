<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fruver Aguacates JJ</title>

    {{-- Fuente y Tailwind --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        footer {
            margin-bottom: 0 !important;
        }
    </style>
</head>

<body class="antialiased bg-green-50 text-gray-800 flex flex-col min-h-screen">

    {{-- ENCABEZADO --}}
    <header class="flex justify-between items-center px-8 py-4 bg-white shadow-md">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('storage/fce40538-d1bf-4350-8839-560932d3fd09.png') }}" 
                 alt="Logo Fruver Aguacates JJ" 
                 class="w-12 h-12 rounded-full shadow-sm">
            <h1 class="text-2xl font-bold text-green-700">Fruver Aguacates JJ</h1>
        </div>
    </header>

    {{-- SECCIÓN PRINCIPAL --}}
    <main class="flex-grow flex flex-col md:flex-row items-center justify-center px-10 py-20 bg-green-100">
        <div class="md:w-1/2 text-center md:text-left md:pl-20 mb-10 md:mb-0">
            <h2 class="text-5xl font-extrabold text-green-800 mb-6 text-center md:text-left">
                Bienvenido a <span class="text-green-600">Fruver Aguacates JJ</span>
            </h2>
            <p class="text-lg text-gray-700 mb-8 text-center md:text-left">
                Frescura, calidad y sabor natural en cada fruta y verdura.  
                ¡Tu fruver de confianza en la ciudad!
            </p>

            @if (Route::has('login'))
                <div class="flex justify-center md:justify-start space-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-6 py-3 bg-green-700 text-white rounded-full shadow hover:bg-green-800 transition">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-6 py-3 bg-green-700 text-white rounded-full shadow hover:bg-green-800 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-6 py-3 border border-green-700 text-green-700 rounded-full shadow hover:bg-green-700 hover:text-white transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('storage/fce40538-d1bf-4350-8839-560932d3fd09.png') }}" 
                 alt="Frutas y Verduras" 
                 class="w-[500px] md:w-[600px] rounded-3xl shadow-2xl transform hover:scale-105 transition duration-500">
        </div>
    </main>

    {{-- PIE DE PÁGINA --}}
    <footer class="bg-white text-center py-4 text-sm text-gray-600 border-t">
        © {{ date('Y') }} Fruver Aguacates JJ — Ana Velasquez y Maria del Mar Perez.
    </footer>
</body>
</html>
