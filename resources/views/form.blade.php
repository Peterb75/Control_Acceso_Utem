<!DOCTYPE html>
<html>
<head>
    <title>Crear Invitado Peatonal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <form action="{{ route('invitado.peatonal.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="Nombres">Nombres</label>
            <input type="text" class="form-control" id="Nombres" name="Nombres" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="ApellidoP">Apellido Paterno</label>
            <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="ApellidoM">Apellido Materno</label>
            <input type="text" class="form-control" id="ApellidoM" name="ApellidoM" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="Correo">Correo</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required maxlength="150">
        </div>
        <div class="form-group">
            <label for="TipoTransporte">Tipo de Transporte</label>
            <input type="text" class="form-control" id="TipoTransporte" name="TipoTransporte" required maxlength="60">
        </div>
        <div class="form-group">
            <label for="FK_TipoInvitado">Tipo de Invitado</label>
            <input type="number" class="form-control" id="FK_TipoInvitado" name="FK_TipoInvitado" required>
        </div>
        <div class="form-group">
            <label for="Edificio">Edificio</label>
            <input type="text" class="form-control" id="Edificio" name="Edificio" required maxlength="30">
        </div>
        <div class="form-group">
            <label for="CantVis">Cantidad de Visitantes</label>
            <input type="number" class="form-control" id="CantVis" name="CantVis" required>
        </div>
        <div class="form-group">
            <label for="MotivioVisit">Motivo de la Visita</label>
            <input type="text" class="form-control" id="MotivioVisit" name="MotivioVisit" required maxlength="100">
        </div>
        <div class="form-group">
            <label for="FechaSolicitada">Fecha Solicitada</label>
            <input type="date" class="form-control" id="FechaSolicitada" name="FechaSolicitada" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
</body>
</html>
