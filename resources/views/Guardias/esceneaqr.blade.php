<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escanea-QR</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

</head>
<body>
<div id="reader" style="width:500px; display:none;"></div>
<button id="start-scan">Iniciar Escáner</button>
<button id="stop-scan" style="display:none;">Detener Escáner</button>

<script>
  let html5QrcodeScanner;

  function onScanSuccess(decodedText, decodedResult) {
      // Enviar el texto decodificado al servidor Laravel
      fetch('/scan-qr', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ code: decodedText })
      })
      .then(response => response.json())
      .then(data => {
          alert(data.message);
      })
      .catch((error) => {
          console.error('Error:', error);
      });
  }

  function onScanFailure(error) {
      console.warn(`QR error = ${error}`);
  }

  document.getElementById('start-scan').addEventListener('click', function() {
      document.getElementById('reader').style.display = 'block';
      document.getElementById('start-scan').style.display = 'none';
      document.getElementById('stop-scan').style.display = 'block';

      html5QrcodeScanner = new Html5QrcodeScanner(
          "reader", { fps: 10, qrbox: 250 });
      html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  });

  document.getElementById('stop-scan').addEventListener('click', function() {
      html5QrcodeScanner.clear().then(_ => {
          document.getElementById('reader').style.display = 'none';
          document.getElementById('start-scan').style.display = 'block';
          document.getElementById('stop-scan').style.display = 'none';
      }).catch(error => {
          console.error('Error stopping the scan: ', error);
      });
  });
</script>


</body>
</html>