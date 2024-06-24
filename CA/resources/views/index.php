<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Invitado</title>
</head>
<body>
    <h1>Seleccionar Tipo de Invitado</h1>
    
    <form action="{{ route('form.invitado') }}" method="GET">
        <button type="submit" name="tipoInvitado" value="1">Tipo Invitado 1</button>
        <button type="submit" name="tipoInvitado" value="2">Tipo Invitado 2</button>
        <button type="submit" name="tipoInvitado" value="3">Tipo Invitado 3</button>
    </form>
</body>
</html>
