<?php
$fileBooking = __DIR__ . "/data/booking_trip.txt";
$daftarBooking = [];

if (file_exists($fileBooking)) {
    // TODO:
    // Baca seluruh baris menggunakan file().
    // Gunakan FILE_IGNORE_NEW_LINES dan FILE_SKIP_EMPTY_LINES.
    // Simpan hasilnya ke $daftarBooking.
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Booking - IndoExplore</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-list">
        <nav class="navbar navbar-list">
            <a class="logo" href="index.php">IndoExplore</a>

            <div class="nav-links">
                <a href="index.php">Beranda</a>
                <a href="index.php#paket">Paket</a>
                <a href="index.php#booking">Booking</a>
                <a href="listbooking.php" class="nav-active">
                    Hasil Booking
                </a>
            </div>
        </nav>

        <div class="header-list-content">
            <p class="label">DATA PEMESANAN</p>
            <h1>Daftar Booking Trip</h1>
            <p>Data pemesanan yang tersimpan di booking_trip.txt.</p>
        </div>
    </header>

    <main class="section list-booking-section">
        <?php if (empty($daftarBooking)): ?>
            <div class="empty-booking">
                <h2>Belum ada booking</h2>
                <p>Data pemesanan akan muncul setelah form berhasil dikirim.</p>

                <a href="index.php#booking" class="tombol">
                    Buat Booking
                </a>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>WhatsApp</th>
                            <th>Destinasi</th>
                            <th>Peserta</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($daftarBooking as $index => $baris): ?>
                            <?php
                            // TODO:
                            // Pecah $baris menggunakan explode("|", $baris).
                            // Pastikan jumlah kolom sesuai format booking.
                            ?>

                            <tr>
                                <td><?php echo $index + 1; ?></td>

                                <!-- TODO: tampilkan setiap kolom data -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
