<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Invitado</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Fuente y CSS personalizado -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pamisform.css')}}">
</head>
<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow-lg border-0 rounded-4 p-5" style="max-width: 700px; width: 100%;">
            <h2 class="text-center mb-4 fw-bold text-teal"><i class="bi bi-person-plus-fill"></i> Crear Invitado</h2>

            <form action="{{ route('CrearInv') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="FK_TipoInvitado" value="{{ request()->input('tipo_invitado') }}">

                <!-- Datos personales -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="Nombres" name="Nombres" required maxlength="50">
                    </div>
                    <div class="col-md-6">
                        <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" required maxlength="50">
                    </div>
                    <div class="col-md-6">
                        <label for="ApellidoM" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="ApellidoM" name="ApellidoM" required maxlength="50">
                    </div>
                    <div class="col-md-6">
                        <label for="Correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="Correo" name="Correo" required maxlength="150">
                    </div>
                </div>

                <hr class="my-4">

                <!-- Transporte -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="TipoTransporte" class="form-label">Tipo de Transporte</label>
                        <select class="form-select" name="TipoTransporte" id="TipoTransporte" required onchange="showVehicleFields(this.value)">
                            <option value="Peatonal" selected>Peatonal</option>
                            <option value="Vehicular">Vehicular</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Edificio" class="form-label">Edificio</label>
                        <select class="form-select" id="Edificio" name="Edificio" required>
                            <option value="Edificio 1" selected>Edificio 1</option> 
                            <option value="Edificio 2">Edificio 2</option>
                            <option value="Edf. Gastronomia">Edf. Gastronomía</option>
                            <option value="Edf. Mantenimiento">Edf. Mantenimiento</option>
                            <option value="Cafeteria">Cafetería</option>
                            <option value="Biblioteca">Biblioteca</option>
                            <option value="Simulador Arancelario">Simulador Arancelario</option>
                            <option value="Edf. Renovables">Edf. Renovables</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="CantVis" class="form-label">Cantidad de Visitantes</label>
                        <input type="number" class="form-control" id="CantVis" name="CantVis" required onchange="updateVisitorFields()">
                    </div>
                    <div class="col-md-6">
                        <label for="MotivoVisit" class="form-label">Motivo de la Visita</label>
                        <input type="text" class="form-control" id="MotivoVisit" name="MotivoVisit" required maxlength="100">
                    </div>
                </div>

                <div id="visitorFields" class="mt-3"></div>

                <div class="form-group mt-3">
                    <label for="FechaSolicitada" class="form-label">Fecha y Hora Solicitada</label>
                    <input type="datetime-local" class="form-control" id="FechaSolicitada" name="Fecha_Hora_Solicitada" required>
                </div>

                <!-- Vehículo -->
                <fieldset id="datosVehiculo" class="mt-4 border rounded-3 p-3 bg-light" style="display: none;">
                    <legend class="text-teal fw-semibold"><i class="bi bi-car-front"></i> Datos del Vehículo</legend>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="TipoVehiculo" class="form-label">Tipo de Vehículo</label>
                            <select class="form-select" name="TipoVehiculo" id="TipoVehiculo">
                                <option value="Carro">Carro</option>
                                <option value="Moto">Moto</option>
                            </select>
                        </div>
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

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary-custom px-5">
                        <i class="bi bi-send-fill"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showVehicleFields(value) {
            document.getElementById('datosVehiculo').style.display = value === 'Vehicular' ? 'block' : 'none';
        }

        function updateVisitorFields() {
            var cantVis = document.getElementById('CantVis').value;
            var visitorFields = document.getElementById('visitorFields');
            visitorFields.innerHTML = '';

            for (var i = 1; i < cantVis; i++) {
                var div = document.createElement('div');
                div.className = 'form-group mb-2';
                div.innerHTML = `
                    <label class="form-label">Nombre de acompañante ${i}</label>
                    <input type="text" class="form-control" name="Acompanante_${i}" required>
                `;
                visitorFields.appendChild(div);
            }
        }
    </script>
</body>
</html>
