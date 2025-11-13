<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Invitado</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fuente y estilos personalizados -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/paeltipo.css') }}">
</head>
<body>

    <!-- Contenedor principal -->
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center bg-light">
        <div class="card shadow-lg border-0 rounded-4 p-5" style="max-width: 600px; background-color: #ffffff;">
            <h1 class="text-center mb-4 fw-bold text-teal">Seleccionar Tipo de Invitado</h1>

            <form action="/Invitado/Formulario" method="GET" class="d-flex flex-column gap-3">
                <button class="btn-invitado" type="submit" name="tipo_invitado" value="1">
                    <i class="bi bi-person-fill"></i> Externo
                </button>

                <button class="btn-invitado" type="submit" name="tipo_invitado" value="2">
                    <i class="bi bi-building"></i> Institucional
                </button>

                <button class="btn-invitado" type="submit" name="tipo_invitado" value="3">
                    <i class="bi bi-truck"></i> Proveedor
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>
</html>
