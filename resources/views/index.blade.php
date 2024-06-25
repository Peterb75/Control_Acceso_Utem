<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Invitado</title>
</head>
<body>
    <h1>Seleccionar Tipo de Invitado</h1>
    
    <form action="{{ route('mostrarFormulario') }}" method="GET">
        <button type="submit" name="tipoInvitado" value="1">Externo</button>
        <button type="submit" name="tipoInvitado" value="2">Escolar</button>
        <button type="submit" name="tipoInvitado" value="3">Proveedor</button>
    </form>
</body>
</html>
