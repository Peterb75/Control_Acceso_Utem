<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Código QR</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Iconos Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        header {
            background-color: #0d6efd;
            color: white;
            padding: 15px 0;
        }
        .logo {
            font-weight: bold;
            font-size: 1.3rem;
        }
        .qr-card {
            max-width: 450px;
            margin: 50px auto;
        }
    </style>
</head>
<body>

    {{-- Header con logo, usuario y botón de cerrar sesión --}}
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <i class="bi bi-qr-code"></i> Sistema de Invitados
        </div>

        <div class="d-flex align-items-center">
            {{-- Mostrar botones según el tipo de usuario --}}
            @if ($user->FK_TipoUsuario == 1 || $user->FK_TipoUsuario == 2)
                <a href="{{ route('home.alumno') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            @elseif ($user->FK_TipoUsuario == 3)
                <a href="{{ route('guardias.panel') }}" class="btn btn-warning btn-sm me-2 text-dark">
                    <i class="bi bi-shield-lock"></i> Panel de Guardias
                </a>
            @endif

            {{-- Nombre del usuario --}}
            <span class="me-3">
                <i class="bi bi-person-circle"></i> {{ $user->Nombre ?? $user->name ?? 'Usuario' }}
            </span>

            {{-- Botón de cerrar sesión --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>

{{-- Contenido principal --}}
    <main class="container mt-5">
        <div class="card shadow-lg qr-card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Tu Código QR Personal</h4>
            </div>

            <div class="card-body text-center">
                {{-- Mensajes de error --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Mostrar QR --}}
                @if ($qrUsuario && $qrUsuario->QR_imgUser)
                    <p class="mb-3">Escanea o descarga tu código QR:</p>

                    <img 
                        src="{{ asset('qrcodes/' . $qrUsuario->QR_imgUser . '.png') }}" 
                        alt="Código QR del usuario" 
                        class="img-fluid border p-2 rounded shadow-sm" 
                        style="max-width: 250px;"
                    >

                    <div class="mt-4">
                        <a href="{{ asset('qrcodes/' . $qrUsuario->QR_imgUser . '.png') }}" 
                           download 
                           class="btn btn-success">
                            <i class="bi bi-download"></i> Descargar QR
                        </a>
                    </div>
                @else
                    <p class="text-danger mt-3">No tienes un código QR asignado aún.</p>
                @endif
            </div>

            <div class="card-footer text-center">
                <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-house-door"></i> Volver al inicio
                </a>
            </div>
        </div>
    </main>

</body>
</html>
