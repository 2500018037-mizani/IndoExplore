# IndoExplore Starter

Starter ini hanya menyediakan struktur proyek dan tampilan awal. Logika yang menjadi penilaian responsi masih ditandai dengan `TODO` dan harus dikerjakan sendiri.

## Menjalankan secara lokal

1. Ekstrak ZIP.
2. Buka terminal di dalam folder.
3. Jalankan:

```bash
php -S localhost:8000
```

4. Buka `http://localhost:8000`.

## File utama

- `index.php`: tampilan katalog, form, dan tempat logika PHP.
- `style.css`: tata letak responsif CSS Grid/Flexbox.
- `script.js`: tempat validasi JavaScript DOM.
- `data/booking_trip.txt`: penyimpanan booking.
- `data/traffic_trip.txt`: penyimpanan hit counter.
- `Dockerfile`: konfigurasi deploy PHP di Railway.

## Deploy Railway

1. Upload folder ke repository GitHub.
2. Buat proyek baru di Railway dari repository tersebut.
3. Railway akan membaca `Dockerfile`.
4. Buat domain dari menu Networking/Settings proyek.
5. Untuk file TXT yang perlu tetap tersimpan, pasang Railway Volume ke `/app/data`.

Catatan: menu Railway dapat berubah. Jangan membuat layanan MySQL/PostgreSQL karena soal meminta penyimpanan file TXT.
