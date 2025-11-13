<!DOCTYPE html>
<html>
<head>
    <title>Vista Protegida</title>
</head>
<body>
    <h1>Bienvenido a la Vista Protegida</h1>
    <button id="logoutButton">Cerrar Sesión</button>

    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });
    </script>
</body>
</html>
