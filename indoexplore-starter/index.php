<?php
// TODO 1:
// Baca nilai dari file data/traffic_trip.txt.
// Tambahkan nilainya satu.
// Simpan kembali tanpa menghapus isi file yang diperlukan.

$totalPengunjung = 0;
$pesan = "";

// TODO 2:
// Saat request POST:
// 1. Ambil data nama, WhatsApp, destinasi, dan jumlah peserta.
// 2. Bersihkan serta validasi input menggunakan PHP.
// 3. Susun satu baris data booking.
// 4. Simpan ke data/booking_trip.txt menggunakan mode append.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndoExplore - Paket Open Trip Lokal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="hero">
        <nav class="navbar">
            <a class="logo" href="#beranda">IndoExplore</a>
            <div class="nav-links">
                <a href="#paket">Paket</a>
                <a href="#booking">Booking</a>
            </div>
        </nav>

        <section id="beranda" class="hero-content">
            <p class="label">OPEN TRIP LOKAL INDONESIA</p>
            <h1>Jelajahi destinasi terbaik bersama IndoExplore</h1>
            <p>
                Pilih paket perjalanan lokal dan lakukan pemesanan kursi
                melalui formulir yang tersedia.
            </p>
            <a class="tombol" href="#paket">Lihat Paket</a>
        </section>
    </header>

    <main>
        <section id="paket" class="section">
            <div class="section-heading">
                <p class="label">KATALOG PERJALANAN</p>
                <h2>Paket Open Trip</h2>
            </div>

            <div class="daftar-paket">
                <article class="kartu-paket">
                    <div class="placeholder-gambar">Tambahkan foto Bromo</div>
                    <div class="isi-kartu">
                        <h3>Open Trip Bromo</h3>
                        <p><strong>Durasi:</strong> 2 hari 1 malam</p>
                        <p><strong>Fasilitas:</strong> Transportasi, penginapan, makan, dokumentasi</p>
                        <p class="harga">Rp750.000 / orang</p>
                    </div>
                </article>

                <article class="kartu-paket">
                    <div class="placeholder-gambar">Tambahkan foto Dieng</div>
                    <div class="isi-kartu">
                        <h3>Open Trip Dieng</h3>
                        <p><strong>Durasi:</strong> 2 hari 1 malam</p>
                        <p><strong>Fasilitas:</strong> Transportasi, tiket wisata, makan, pemandu</p>
                        <p class="harga">Rp650.000 / orang</p>
                    </div>
                </article>

                <article class="kartu-paket">
                    <div class="placeholder-gambar">Tambahkan foto Karimunjawa</div>
                    <div class="isi-kartu">
                        <h3>Open Trip Karimunjawa</h3>
                        <p><strong>Durasi:</strong> 3 hari 2 malam</p>
                        <p><strong>Fasilitas:</strong> Kapal, penginapan, makan, snorkeling</p>
                        <p class="harga">Rp1.250.000 / orang</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="booking" class="section section-booking">
            <div class="section-heading">
                <p class="label">FORM PEMESANAN</p>
                <h2>Pesan Kursi Trip</h2>
            </div>

            <?php if ($pesan !== ""): ?>
                <div class="pesan"><?php echo htmlspecialchars($pesan); ?></div>
            <?php endif; ?>

            <form id="formBooking" method="post" action="" novalidate>
                <div class="form-group">
                    <label for="nama">Nama Pemesan</label>
                    <input type="text" id="nama" name="nama" autocomplete="name">
                    <small class="error" id="errorNama"></small>
                </div>

                <div class="form-group">
                    <label for="whatsapp">Nomor WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" inputmode="numeric">
                    <small class="error" id="errorWhatsapp"></small>
                </div>

                <div class="form-group">
                    <label for="destinasi">Pilihan Destinasi</label>
                    <select id="destinasi" name="destinasi">
                        <option value="">-- Pilih Destinasi --</option>
                        <option value="Bromo">Bromo</option>
                        <option value="Dieng">Dieng</option>
                        <option value="Karimunjawa">Karimunjawa</option>
                    </select>
                    <small class="error" id="errorDestinasi"></small>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah Peserta</label>
                    <input type="number" id="jumlah" name="jumlah" min="1">
                    <small class="error" id="errorJumlah"></small>
                </div>

                <button class="tombol" type="submit">Kirim Booking</button>
            </form>
        </section>

        <section class="counter">
            <p>Total Pengunjung Website</p>
            <strong><?php echo $totalPengunjung; ?></strong>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 IndoExplore</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
