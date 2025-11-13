<!DOCTYPE html>
<html>
<head>
    <title>Código QR de Invitación</title>
</head>
<body>
    <h1>Código QR de Invitación</h1>

    <p>Estimado(a) {{ $Nombres }} {{ $ApellidoP }},</p>
    
    <p>A continuación, encontrará el código QR para su acceso:</p>
    
    <img src="{{ $message->embed($qrPath) }}" alt="QR Code">
    
    <p>Por favor, presente este código QR al ingresar.</p>
    
    <p>Gracias,<br>
    El equipo de organización</p>
</body>
</html>
