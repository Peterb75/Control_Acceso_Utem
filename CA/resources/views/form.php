<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>Formulario de Registro de Persona, Invitado y Vehículo</h1>
    <form action="http://localhost:8000/api/invitados/Vehiculo" method="POST">
        @csrf
        <!-- Datos de la Persona -->
        <fieldset>
            <legend>Datos de la Persona</legend>
            <label for="Nombres">Nombres:</label>
            <input type="text" id="Nombres" name="Nombres" maxlength="50" required><br>

            <label for="ApellidoP">Apellido Paterno:</label>
            <input type="text" id="ApellidoP" name="ApellidoP" maxlength="50" required><br>

            <label for="ApellidoM">Apellido Materno:</label>
            <input type="text" id="ApellidoM" name="ApellidoM" maxlength="50" required><br>

            <label for="Correo">Correo:</label>
            <input type="email" id="Correo" name="Correo" maxlength="150" required><br>

            <label for="TipoTransporte">Tipo de Transporte:</label>
            <input type="text" id="TipoTransporte" name="TipoTransporte" maxlength="60" required><br>

        </fieldset>

        <!-- Datos del Invitado -->
        <fieldset>
            <legend>Datos del Invitado</legend>
            <label for="Edificio">Edificio:</label>
            <input type="text" id="Edificio" name="Edificio" maxlength="30" required><br>

            <label for="CantVis">Cantidad de Visitantes:</label>
            <input type="number" id="CantVis" name="CantVis" required><br>

            <label for="MotivioVisit">Motivo de la Visita:</label>
            <input type="text" id="MotivioVisit" name="MotivioVisit" maxlength="100"><br>

            <label for="FechaSolicitada">Fecha Solicitada:</label>
            <input type="date" id="FechaSolicitada" name="FechaSolicitada" required><br>
        </fieldset>

        <!-- Datos del Vehículo -->
        <fieldset>
            <legend>Datos del Vehículo</legend>
            <label for="MarcaV">Marca:</label>
            <input type="text" id="MarcaV" name="MarcaV" maxlength="100" required><br>

            <label for="ModeloV">Modelo:</label>
            <input type="text" id="ModeloV" name="ModeloV" maxlength="100" required><br>

            <label for="ColorV">Color:</label>
            <input type="text" id="ColorV" name="ColorV" maxlength="40" required><br>

            <label for="Placas">Placas:</label>
            <input type="text" id="Placas" name="Placas" maxlength="80" required><br>
        </fieldset>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
