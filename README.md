## Look for Job

Proyek ini adalah aplikasi berbasis Laravel yang dirancang untuk membantu pengguna mencari dan melamar pekerjaan. Aplikasi ini memungkinkan pencari kerja untuk membuat dan mengelola profil, mencari pekerjaan, dan melamar pekerjaan dengan mudah.

Daftar Isi:

- [Instalasi](#Instalasi).
- [Konfigurasi](#Konfigurasi).
- [Penggunaan](#Penggunaan)
- [Kontribusi](#Kontribusi)
- [Lisensi](#Lisensi)
- [Detail .gitignore](#Detail)

## Instalasi

1. Clone repositori:
   git clone https://github.com/username/look-for-job.git

2. Masuk ke direktori proyek:
   cd look-for-job

3. Install dependensi:
   composer install

4. Salin file .env:
   cp .env.example .env

5. Generate kunci aplikasi:
   php artisan key:generate

6. Sesuaikan konfigurasi .env (lihat bagian konfigurasi)

7. Jalankan migrasi:
   php artisan migrate

8. Jalankan server:
   php artisan serve

Aplikasi akan berjalan di http://localhost:8000.

## Konfigurasi

Sesuaikan file .env dengan konfigurasi lokal, seperti:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=look_for_job
DB_USERNAME=root
DB_PASSWORD=

Untuk email, antrean, dan cache, sesuaikan juga bagian terkait di file .env.

## Penggunaan

Setelah aplikasi berjalan, pengguna dapat:
- Membuat dan mengedit profil
- Mencari dan melamar pekerjaan
- Melihat status lamaran

## Kontribusi

Kami terbuka terhadap kontribusi:
1. Fork repo ini
2. Buat branch baru
3. Lakukan perubahan dan commit
4. Push ke repo Anda dan buat Pull Request

Pastikan mengikuti standar PSR-12 dan menambahkan pengujian bila perlu.

## Lisensi

Proyek ini dilisensikan dengan Lisensi MIT. Silakan lihat file LICENSE untuk informasi selengkapnya.

## Detail

Beberapa file diabaikan dalam git karena alasan keamanan atau dapat dihasilkan ulang:

- .env: berisi konfigurasi sensitif
- /vendor/: hasil composer install
- /node_modules/: hasil npm install
- /storage/: data upload, log, cache
- /public/storage/: symlink ke storage/app/public

Pastikan untuk menjalankan:
- composer install
- npm install
- php artisan storage:link
Setelah mengatur .env, jalankan php artisan migrate dan php artisan serve.
