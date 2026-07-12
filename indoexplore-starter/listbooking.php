<?php
$fileBooking = __DIR__ . "/data/booking_trip.txt";

$daftarBooking = [];
$pesanError = "";

$totalBooking = 0;
$totalPeserta = 0;
$totalPendapatan = 0;

$hargaDestinasi = [
    "Bromo" => 750000,
    "Dieng" => 650000,
    "Karimunjawa" => 1250000
];

if (file_exists($fileBooking)) {
    $hasilBaca = file(
        $fileBooking,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    if ($hasilBaca !== false) {
        foreach ($hasilBaca as $baris) {
            $data = explode("|", $baris);

            /*
             * Format baru:
             * kode|tanggal|nama|whatsapp|destinasi|
             * jumlah|harga_satuan|total_harga
             */
            if (count($data) >= 8) {
                $kodeBooking = trim($data[0]);
                $tanggal = trim($data[1]);
                $nama = trim($data[2]);
                $whatsapp = trim($data[3]);
                $destinasi = trim($data[4]);
                $jumlah = (int) trim($data[5]);
                $hargaSatuan = (int) trim($data[6]);
                $totalHarga = (int) trim($data[7]);
            }

            /*
             * Dukungan untuk data lama yang masih
             * memakai lima kolom.
             */
            elseif (count($data) >= 5) {
                $tanggal = trim($data[0]);
                $nama = trim($data[1]);
                $whatsapp = trim($data[2]);
                $destinasi = trim($data[3]);
                $jumlah = (int) trim($data[4]);

                $angkaKode = str_pad(
                    (string) (abs(crc32($baris)) % 100000),
                    5,
                    "0",
                    STR_PAD_LEFT
                );

                $kodeBooking = "#" . $angkaKode . "LGCY";

                $hargaSatuan =
                    $hargaDestinasi[$destinasi] ?? 0;

                $totalHarga =
                    $hargaSatuan * $jumlah;
            } else {
                continue;
            }

            $daftarBooking[] = [
                "kode" => $kodeBooking,
                "tanggal" => $tanggal,
                "nama" => $nama,
                "whatsapp" => $whatsapp,
                "destinasi" => $destinasi,
                "jumlah" => $jumlah,
                "harga_satuan" => $hargaSatuan,
                "total_harga" => $totalHarga
            ];

            $totalBooking++;
            $totalPeserta += $jumlah;
            $totalPendapatan += $totalHarga;
        }

        /*
         * Booking terbaru ditampilkan paling atas.
         */
        $daftarBooking = array_reverse($daftarBooking);
    } else {
        $pesanError =
            "File booking tidak dapat dibaca.";
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
    <link
    rel="icon"
    type="image/png"
    href="images/Logo FAV.png"
>

<link
    rel="apple-touch-icon"
    href="images/favicon.png"
>
</head>

<body>

   <header class="header-list">

    <nav class="navbar navbar-list">

        <a class="navbar-logo" href="index.php">
            <img
                src="images/Logo.png"
                alt="Logo IndoExplore"
            >
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
    </div>

</header>

    <main class="section list-booking-section">
    <div class="booking-summary-grid">

    <article class="summary-card">
        <span>Total Booking</span>

        <strong>
            <?php echo $totalBooking; ?>
        </strong>

        <small>pemesanan tersimpan</small>
    </article>

    <article class="summary-card">
        <span>Total Peserta</span>

        <strong>
            <?php echo $totalPeserta; ?>
        </strong>

        <small>orang mengikuti trip</small>
    </article>

    <article class="summary-card">
        <span>Total Nilai Booking</span>

        <strong class="summary-money">
            Rp<?php echo number_format(
                $totalPendapatan,
                0,
                ",",
                "."
            ); ?>
        </strong>

        <small>seluruh pemesanan</small>
    </article>

</div>

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
                        <th>Kode Booking</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>WhatsApp</th>
                        <th>Destinasi</th>
                        <th>Peserta</th>
                        <th>Harga/Orang</th>
                        <th>Total Harga</th>
                    </tr>
                    </thead>

                    <tbody>

    <?php foreach ($daftarBooking as $index => $booking): ?>

        <tr>
            <td>
                <?php echo $index + 1; ?>
            </td>

            <td>
                <span class="booking-code">
                    <?php echo htmlspecialchars(
                        $booking["kode"],
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>
                </span>
            </td>

            <td>
                <?php echo htmlspecialchars(
                    $booking["tanggal"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>
            </td>

            <td>
                <?php echo htmlspecialchars(
                    $booking["nama"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>
            </td>

            <td>
                <?php echo htmlspecialchars(
                    $booking["whatsapp"],
                    ENT_QUOTES,
                    "UTF-8"
                ); ?>
            </td>

            <td>
                <span class="destination-badge">
                    <?php echo htmlspecialchars(
                        $booking["destinasi"],
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>
                </span>
            </td>

            <td>
                <?php echo (int) $booking["jumlah"]; ?>
                orang
            </td>

            <td>
                Rp<?php echo number_format(
                    $booking["harga_satuan"],
                    0,
                    ",",
                    "."
                ); ?>
            </td>

            <td class="total-price-cell">
                Rp<?php echo number_format(
                    $booking["total_harga"],
                    0,
                    ",",
                    "."
                ); ?>
            </td>
        </tr>

    <?php endforeach; ?>

</tbody>
                </table>

            </div>

        <?php endif; ?>

    </main>

</body>

</html>
