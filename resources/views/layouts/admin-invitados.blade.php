{{-- resources/views/layouts/admin-invitados.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Invitados')</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Bootstrap JS y jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    {{-- Iconos Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Estilos personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/palastablas.css')}}">

    {{-- Stack de estilos adicionales --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('ListSolInv') }}">Solicitudes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('todos') }}">Usuarios</a></li>
                </ul>
                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link btn btn-link text-white" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Contenido dinámico --}}
    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    {{-- Stack de scripts adicionales --}}
    @stack('scripts')
</body>
</html>
