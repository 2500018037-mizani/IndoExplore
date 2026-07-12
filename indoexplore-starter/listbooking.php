<?php
$fileBooking = __DIR__ . "/data/booking_trip.txt";
$daftarBooking = [];
$pesanError = "";

/* Membaca file booking */
if (file_exists($fileBooking)) {
    $hasilBaca = file(
        $fileBooking,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    if ($hasilBaca !== false) {
        $daftarBooking = $hasilBaca;
    } else {
        $pesanError = "File booking tidak dapat dibaca.";
    }
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

            <a class="logo" href="index.php">
                IndoExplore
            </a>

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

            <p class="label">
                DATA PEMESANAN
            </p>

            <h1>
                Daftar Booking Trip
            </h1>

            <p>
                Data pemesanan yang tersimpan di booking_trip.txt.
            </p>

        </div>

    </header>

    <main class="section list-booking-section">

        <?php if ($pesanError !== ""): ?>

            <div class="empty-booking">

                <h2>Terjadi Kesalahan</h2>

                <p>
                    <?php echo htmlspecialchars(
                        $pesanError,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>
                </p>

            </div>

        <?php elseif (empty($daftarBooking)): ?>

            <div class="empty-booking">

                <h2>Belum ada booking</h2>

                <p>
                    Data pemesanan akan muncul setelah form berhasil dikirim.
                </p>

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

                        <?php
                        $nomor = 1;

                        foreach ($daftarBooking as $baris):
                            $data = explode("|", $baris);

                            /*
                             * Format data:
                             * tanggal|nama|whatsapp|destinasi|jumlah
                             */
                            if (count($data) < 5) {
                                continue;
                            }

                            $tanggal = trim($data[0]);
                            $nama = trim($data[1]);
                            $whatsapp = trim($data[2]);
                            $destinasi = trim($data[3]);
                            $jumlah = trim($data[4]);
                        ?>

                            <tr>

                                <td>
                                    <?php echo $nomor; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars(
                                        $tanggal,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars(
                                        $nama,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars(
                                        $whatsapp,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars(
                                        $destinasi,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars(
                                        $jumlah,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ); ?> orang
                                </td>

                            </tr>

                        <?php
                            $nomor++;
                        endforeach;
                        ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </main>

</body>

</html>
