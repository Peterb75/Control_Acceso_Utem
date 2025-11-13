<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Guardia - Escáner QR</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('plugins/qrCode.min.js') }}"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        #qr-canvas {
            width: 100%;
            border-radius: 10px;
        }
        .card {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow p-4 bg-white card text-center">
            <h4 class="mb-3 fw-bold text-primary">Escanear Código QR</h4>

            <div class="mb-3">
                <a id="btn-scan-qr" href="#">
                    <img src="https://cdn-icons-png.flaticon.com/512/2933/2933245.png"
                         class="img-fluid" width="150" alt="QR Icon">
                </a>
                <canvas hidden id="qr-canvas"></canvas>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-success btn-sm" onclick="encenderCamara()">Encender cámara</button>
                <button class="btn btn-danger btn-sm" onclick="cerrarCamara()">Detener cámara</button>
            </div>

            <audio id="audioScaner" src="{{ asset('sonidos/sonido.mp3') }}"></audio>
        </div>
    </div>
</div>

<script>
const video = document.createElement("video");
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");
const btnScanQR = document.getElementById("btn-scan-qr");
let scanning = false;

const encenderCamara = () => {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(stream => {
            scanning = true;
            btnScanQR.hidden = true;
            canvasElement.hidden = false;
            video.setAttribute("playsinline", true);
            video.srcObject = stream;
            video.play();
            tick();
            scan();
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'No se pudo acceder a la cámara. Verifica los permisos.', 'error');
        });
};

function tick() {
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
    scanning && requestAnimationFrame(tick);
}

function scan() {
    try {
        qrcode.decode();
    } catch (e) {
        setTimeout(scan, 300);
    }
}

const cerrarCamara = () => {
    if (video.srcObject) {
        video.srcObject.getTracks().forEach(track => track.stop());
    }
    scanning = false;
    canvasElement.hidden = true;
    btnScanQR.hidden = false;
};

const activarSonido = () => document.getElementById('audioScaner').play();

qrcode.callback = async (respuesta) => {
    if (respuesta) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/api/verify-qr', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ qr: respuesta })
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: data.action === 'entrada' ? 'Entrada registrada' : 'Salida registrada',
                    text: data.message,
                    timer: 2500
                });
                activarSonido();
                cerrarCamara();
            } else {
                Swal.fire('Error', data.error || 'QR inválido o ya usado.', 'error');
            }

        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Ocurrió un problema al procesar el QR.', 'error');
        }
    }
};

window.addEventListener('load', encenderCamara);
</script>
</body>
</html>
