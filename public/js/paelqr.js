//crea elemento
const video = document.createElement("video");

//nuestro camvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

//div donde llegara nuestro canvas
const btnScanQR = document.getElementById("btn-scan-qr");

//lectura desactivada
let scanning = false;

//funcion para encender la camara
const encenderCamara = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function (stream) {
      scanning = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true);
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    })
    .catch(function (err) {
      console.error('Error al acceder a la cámara:', err);
      Swal.fire('Error', 'No se pudo acceder a la cámara. Por favor, revisa los permisos y asegúrate de que la cámara esté disponible.', 'error');
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
    console.error('Error al decodificar el código QR:', e);
    setTimeout(scan, 300);
  }
}

const cerrarCamara = () => {
  if (video.srcObject) {
    video.srcObject.getTracks().forEach((track) => {
      track.stop();
    });
  }
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

const activarSonido = () => {
  var audio = document.getElementById('audioScaner');
  audio.play();
}

qrcode.callback = async (respuesta) => {
  if (respuesta) {
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const response = await fetch('http://127.0.0.1:8000/api/verify-qr', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ qr: respuesta })
      });

      if (!response.ok) {
        throw new Error(`hola  wey`);
      }

      const data = await response.json();

      if (data.error) {
        throw new Error(data.error); // Lanza un error si el servidor devuelve un mensaje de error específico
      }

      if (data.success) {
        if (data.action === 'entrada') {
          Swal.fire(data.message);
        } else if (data.action === 'salida') {
          Swal.fire(data.message);
        }
        activarSonido();
        cerrarCamara();
      } else {
        Swal.fire('ya fue escaneado wey');
      }
    } catch (error) {
      console.error('Error:', error.message);
      alert(JSON.stringify({ error: error.message })); // Muestra el error en formato JSON
      Swal.fire('Error', 'Hubo un problema al verificar el QR. Por favor, inténtalo de nuevo más tarde.', 'error');
    }
  }
};

window.addEventListener('load', (e) => {
  encenderCamara();
});

