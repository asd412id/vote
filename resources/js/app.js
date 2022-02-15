require('./bootstrap');

import Alpine from 'alpinejs';
import axios from 'axios';
import { Html5Qrcode } from "html5-qrcode"

window.Alpine = Alpine;

Alpine.start();

var html5QrCode = null;

window.startScan = () => {
  Html5Qrcode.getCameras().then(devices => {
    /**
     * devices would be an array of objects of type:
     * { id: "id", label: "label" }
     */
    if (devices && devices.length) {
      var cameraId = devices[0].id;
      html5QrCode = new Html5Qrcode(/* element id */ "qr-reader");
      html5QrCode.start(
        cameraId,
        {
          fps: 10,    // Optional, frame per seconds for qr code scanning
          qrbox: 400,  // Optional, if you want bounded box UI
          facingMode: { exact: "environment" }
        },
        (decodedText, decodedResult) => {
          getResult(decodedText);
        },
        (errorMessage) => {
          // parse error, ignore it.
        })
        .catch((err) => {
          document.getElementById('qr-reader').innerHTML = 'Tidak dapat membuka scanner QR!';
        });
    }
  }).catch(err => {
    document.getElementById('qr-reader').innerHTML = 'Tidak dapat membuka scanner QR!';
  });
}

function getResult(text) {
  html5QrCode.stop();
  document.getElementById('qr-reader').innerHTML = 'Mengecek kode ...';
  const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
  axios.post('/login', { code: text, _token: csrfToken }).then(res => {
    document.getElementById('qr-reader').innerHTML = res.data.message;
    setTimeout(() => {
      location.href = res.data.redirect;
    }, 1500);
  }).catch(res => {
    document.getElementById('qr-reader').innerHTML = res.response.data.message;
    setTimeout(() => {
      startScan();
    }, 5000);
  })
}

window.stopScan = () => {
  if (html5QrCode != null) {
    html5QrCode.stop();
    html5QrCode = null;
    document.getElementById('qr-reader').innerHTML = 'Mohon Tunggu ...';
  }
}

window.onload = () => {
  const newurl = location.href.split('#');
  if (newurl.length > 1) {
    location.href = newurl[0];
  }
}