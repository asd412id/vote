## Vote Online (E-Vote)
Merupakan aplikasi untuk melakukan voting online dengan mudah, cukup dengan scan QR Code.

## Cara Install
- Clone repo ini
- Buka terminal/cmd/powershell dan jalankan **_composer update_**. Tunggu hingga proses selesai
- Salin file _.env.example_ menjadi _.env_ kemudian edit file .env dan sesuaikan pengaturan nama aplikasi dan database
- Selanjutnya jalankan **_php artisan migrate --seed_** di terminal untuk menggenerate database
- Jalankan **_php artisan serve_** dan buka browser kemudian akses alamat **http://127.0.0.1:8000**