<!DOCTYPE html>
<html>
<head>
    <title>Solicitud Denegada</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #b30000;">Notificación de Solicitud Denegada</h2>

    <p>Estimado(a) <strong>{{ $Nombres }} {{ $ApellidoP }}</strong>,</p>

    <p>Lamentamos informarle que su solicitud de invitación con fecha 
    <strong>{{ \Carbon\Carbon::parse($Fecha)->format('d/m/Y H:i') }}</strong> 
    ha sido <strong>denegada</strong>.</p>

    <p><strong>Motivo del rechazo:</strong> {{ $Motivo }}</p>

    <p>Si considera que se trata de un error o necesita más información, 
    puede comunicarse con el área de administración.</p>

    <br>
    <p>Atentamente,<br>
    <strong>Equipo de Invitaciones</strong></p>
</body>
</html>
