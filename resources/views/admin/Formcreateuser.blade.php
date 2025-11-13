<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Fuente y estilo -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            max-width: 900px;
            border-radius: 1rem;
            border: none;
        }
        fieldset {
            background-color: #f8f9fc;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
        }
        legend {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .form-control,
        .form-select {
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="container min-vh-100 d-flex justify-content-center align-items-center py-5">
    <div class="card shadow-lg p-5 bg-white w-100">
        <h2 class="text-center mb-4 fw-bold text-primary">
            <i class="bi bi-person-fill-add"></i> Crear Usuario
        </h2>

        <form action="{{ route('CreateUser') }}" method="POST" novalidate>
            @csrf

            <!-- DATOS PERSONALES -->
            <fieldset class="mb-4 p-3">
                <legend class="text-primary"><i class="bi bi-person-lines-fill"></i> Datos Personales</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="Nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="Nombres" name="Nombres" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ApellidoM" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="ApellidoM" name="ApellidoM" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="Correo" name="Correo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Num_Iden" class="form-label">Número de Identificación</label>
                        <input type="number" class="form-control" id="Num_Iden" name="Num_Iden" required>
                    </div>
                </div>
            </fieldset>

            <!-- DATOS LABORALES / ACADÉMICOS -->
            <fieldset class="mb-4 p-3">
                <legend class="text-primary"><i class="bi bi-building"></i> Datos de Usuario</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="FK_TipoUsuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" name="FK_TipoUsuario" id="FK_TipoUsuario" required onchange="mostrarCamposTipoUsuario()">
                            <option value="">Seleccione un tipo</option>
                            <option value="1">Alumno</option>
                            <option value="2">Empleado</option>
                            <option value="3">Administrador</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Activo" class="form-label">Estado</label>
                        <select class="form-select" id="Activo" name="Activo" required>
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Campos de alumno -->
                <div id="datosAlumno" class="row g-3 mt-2" style="display:none;">
                    <div class="col-md-6">
                        <label for="Carrera" class="form-label">Carrera</label>
                        <input type="text" class="form-control" id="Carrera" name="Carrera" maxlength="30">
                    </div>
                    <div class="col-md-6">
                        <label for="Grupo" class="form-label">Grupo</label>
                        <input type="text" class="form-control" id="Grupo" name="Grupo" maxlength="30">
                    </div>
                </div>

                <!-- Campos laborales -->
                <div id="datosLaborales" class="row g-3 mt-2" style="display:none;">
                    <div class="col-md-6">
                        <label for="FK_Id_Area" class="form-label">Área</label>
                        <select class="form-select" name="FK_Id_Area" id="FK_Id_Area">
                            <option value="">Seleccione área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->Id_Area }}">{{ $area->NombreArea }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="FK_Id_Puesto" class="form-label">Puesto</label>
                        <select class="form-select" name="FK_Id_Puesto" id="FK_Id_Puesto">
                            <option value="">Seleccione puesto</option>
                            @foreach($puestos as $puesto)
                                <option value="{{ $puesto->Id_Puesto }}">{{ $puesto->NombrePuesto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- DATOS DE ACCESO -->
            <fieldset class="mb-4 p-3">
                <legend class="text-primary"><i class="bi bi-lock-fill"></i> Datos de Acceso</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="Password" name="Password" required>
                    </div>
                    <div class="col-md-3">
                        <label for="HoraFija_Entrada" class="form-label">Hora Entrada</label>
                        <input type="time" step="1" class="form-control" id="HoraFija_Entrada" name="HoraFija_Entrada" required>
                    </div>
                    <div class="col-md-3">
                        <label for="HoraFija_Salida" class="form-label">Hora Salida</label>
                        <input type="time" step="1" class="form-control" id="HoraFija_Salida" name="HoraFija_Salida" required>
                    </div>
                </div>
            </fieldset>

            <!-- TRANSPORTE -->
            <fieldset class="mb-4 p-3">
                <legend class="text-primary"><i class="bi bi-car-front"></i> Transporte</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="TipoTransporte" class="form-label">Tipo de Transporte</label>
                        <select class="form-select" name="TipoTransporte" id="TipoTransporte" required onchange="mostrarCamposVehiculo()">
                            <option value="Peatonal" selected>Peatonal</option>
                            <option value="Vehicular">Vehicular</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="TipoVehiculo" class="form-label">Tipo de Vehículo</label>
                        <input type="text" class="form-control" id="TipoVehiculo" name="TipoVehiculo" maxlength="100">
                    </div>
                </div>

                <div id="datosVehiculo" class="row g-3 mt-3" style="display:none;">
                    <div class="col-md-6">
                        <label for="MarcaV" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="MarcaV" name="MarcaV" maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label for="ModeloV" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="ModeloV" name="ModeloV" maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label for="ColorV" class="form-label">Color</label>
                        <input type="text" class="form-control" id="ColorV" name="ColorV" maxlength="40">
                    </div>
                    <div class="col-md-6">
                        <label for="Placas" class="form-label">Placas</label>
                        <input type="text" class="form-control" id="Placas" name="Placas" maxlength="80">
                    </div>
                </div>
            </fieldset>

            <!-- BOTÓN -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-send-fill"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar campos según el tipo de usuario
    function mostrarCamposTipoUsuario() {
        const tipo = document.getElementById('FK_TipoUsuario').value;
        const datosAlumno = document.getElementById('datosAlumno');
        const datosLaborales = document.getElementById('datosLaborales');

        if (tipo === '1') { // Alumno
            datosAlumno.style.display = 'flex';
            datosLaborales.style.display = 'none';
        } else if (tipo === '2' || tipo === '3') { // Empleado o Admin
            datosAlumno.style.display = 'none';
            datosLaborales.style.display = 'flex';
        } else {
            datosAlumno.style.display = 'none';
            datosLaborales.style.display = 'none';
        }
    }

    // Mostrar u ocultar campos de vehículo
    function mostrarCamposVehiculo() {
        const tipo = document.getElementById('TipoTransporte').value;
        document.getElementById('datosVehiculo').style.display = (tipo === 'Vehicular') ? 'flex' : 'none';
    }
</script>
</body>
</html>
