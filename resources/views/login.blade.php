<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

        <!-- Display error messages if any -->
        @if ($errors->has('Num_Iden'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first('Num_Iden') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="Num_Iden" class="block text-sm font-medium text-gray-700">Número de Identificación</label>
                <input type="text" name="Num_Iden" id="Num_Iden" value="{{ old('Num_Iden') }}" 
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>

            <div class="mb-6">
                <label for="Password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="Password" id="Password" 
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            ¿Quieres visitarnos? da click aqui <a href="{{ route('visitanos') }}" class="text-blue-600 hover:underline">¡Visítanos!</a>

        </p>
    </div>
</body>
</html>