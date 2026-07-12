<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if (
    $_SERVER["REQUEST_METHOD"] === "GET" &&
    empty($_SESSION["booking_token"])
) {
    $_SESSION["booking_token"] = bin2hex(random_bytes(32));
}

$folderData = __DIR__ . "/data";
$fileTraffic = $folderData . "/traffic_trip.txt";
$fileBooking = $folderData . "/booking_trip.txt";

$totalPengunjung = 0;
$pesan = "";

/* Membuat folder data jika belum tersedia */
if (!is_dir($folderData)) {
    mkdir($folderData, 0775, true);
}

/* Membuat file traffic jika belum tersedia */
if (!file_exists($fileTraffic)) {
    file_put_contents($fileTraffic, "0");
}

/* Membuat file booking jika belum tersedia */
if (!file_exists($fileBooking)) {
    file_put_contents($fileBooking, "");
}

/* =========================================
   PROSES PENYIMPANAN BOOKING
========================================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tokenForm = $_POST["booking_token"] ?? "";
    $tokenSession = $_SESSION["booking_token"] ?? "";
    
    $nama = trim($_POST["nama"] ?? "");
    $whatsapp = trim($_POST["whatsapp"] ?? "");
    $destinasi = trim($_POST["destinasi"] ?? "");
    $jumlah = filter_var(
        $_POST["jumlah"] ?? null,
        FILTER_VALIDATE_INT
    );

    $daftarError = [];

    /* Validasi nama */
    if ($nama === "") {
        $daftarError[] = "Nama pemesan wajib diisi.";
    }

    /* Validasi WhatsApp */
    if (!preg_match("/^[0-9]{10,}$/", $whatsapp)) {
        $daftarError[] =
            "Nomor WhatsApp harus berupa angka dan minimal 10 digit.";
    }

    /* Validasi destinasi */
    $destinasiTersedia = [
        "Bromo",
        "Dieng",
        "Karimunjawa"
    ];

    if (!in_array($destinasi, $destinasiTersedia, true)) {
        $daftarError[] = "Destinasi yang dipilih tidak valid.";
    }

    /* Validasi jumlah peserta */
    if ($jumlah === false || $jumlah < 1) {
        $daftarError[] = "Jumlah peserta minimal 1 orang.";
    }

    /* Jika tidak ada kesalahan */
    if (empty($daftarError)) {
        /*
         * Menghapus karakter yang dapat merusak
         * format pemisah data.
         */
        $namaAman = preg_replace(
            "/[\r\n|]+/",
            " ",
            $nama
        );

        $whatsappAman = preg_replace(
            "/[\r\n|]+/",
            "",
            $whatsapp
        );

        $tanggalBooking = date("Y-m-d H:i:s");

        /*
         * Format:
         * tanggal|nama|whatsapp|destinasi|jumlah
         */
        $dataBooking = implode(
            "|",
            [
                $tanggalBooking,
                $namaAman,
                $whatsappAman,
                $destinasi,
                $jumlah
            ]
        ) . PHP_EOL;

        /*
         * FILE_APPEND digunakan agar data lama
         * tidak tertimpa.
         */
        $hasilSimpan = file_put_contents(
            $fileBooking,
            $dataBooking,
            FILE_APPEND | LOCK_EX
        );

        if ($hasilSimpan === false) {
    $pesan =
        "Booking gagal disimpan. Periksa izin folder data.";
} else {
    unset($_SESSION["booking_token"]);

    header(
        "Location: index.php?status=berhasil#booking"
    );

    exit;
}
    } else {
        $pesan = implode(" ", $daftarError);
    }
}

/* Pesan setelah redirect berhasil */
if (
    isset($_GET["status"]) &&
    $_GET["status"] === "berhasil"
) {
    $pesan = "Booking berhasil disimpan.";
}

/* =========================================
   HIT COUNTER
========================================= */

$file = fopen($fileTraffic, "c+");

if ($file !== false) {
    if (flock($file, LOCK_EX)) {
        rewind($file);

        $isiTraffic = trim(
            stream_get_contents($file)
        );

        if (
            $isiTraffic === "" ||
            !is_numeric($isiTraffic)
        ) {
            $isiTraffic = 0;
        }

        $totalPengunjung = (int) $isiTraffic;

        /*
         * Counter hanya bertambah pada request GET.
         * Dengan begitu submit POST lalu redirect
         * tidak dihitung dua kali.
         */
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $totalPengunjung++;

            ftruncate($file, 0);
            rewind($file);

            fwrite(
                $file,
                (string) $totalPengunjung
            );

            fflush($file);
        }

        flock($file, LOCK_UN);
    }

    fclose($file);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndoExplore - Paket Open Trip Lokal</title>
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
    <div id="openingIntro" class="opening-intro">
    <div class="opening-overlay"></div>

    <div class="opening-decoration decoration-one"></div>
    <div class="opening-decoration decoration-two"></div>

    <div class="opening-content">
        <p class="opening-small">WELCOME TO</p>

        <h1 class="opening-logo">
            Indo<span>Explore</span>
        </h1>

        <div class="opening-line"></div>

        <p class="opening-tagline">
            Temukan cerita baru di setiap perjalanan
        </p>

        <button id="enterWebsite" class="opening-button">
            <span>Mulai Menjelajah</span>
            <span class="opening-arrow">→</span>
        </button>
    </div>

    <div class="scroll-indicator">
        <span></span>
        <p>EXPLORE</p>
    </div>
</div>
    <header class="hero">
    <nav class="navbar">
        <a class="navbar-logo" href="index.php#beranda">
            <img
                src="images/Logo.png"
                alt="Logo IndoExplore"
            >
        </a>

        <div class="nav-links">
            <a href="index.php">Beranda</a>
            <a href="#paket">Paket</a>
            <a href="#booking">Booking</a>
            <a href="listbooking.php">Hasil Booking</a>
        </div>
    </nav>

    <section id="beranda" class="hero-content">
        <p class="label">OPEN TRIP LOKAL INDONESIA</p>

        <h1>
            Jelajahi destinasi terbaik bersama IndoExplore
        </h1>

        <p>
            Pilih paket perjalanan lokal dan lakukan pemesanan kursi
            melalui formulir yang tersedia.
        </p>

        <a class="tombol" href="#paket">
            Lihat Paket
        </a>
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
                    <img src="images/imgbromo.jpg" alt="Wisata Gunung Bromo">
                    <div class="isi-kartu">
                        <h3>Open Trip Bromo</h3>
                        <p><strong>Durasi:</strong> 2 hari 1 malam</p>
                        <p><strong>Fasilitas:</strong> Transportasi, penginapan, makan, dokumentasi</p>
                        <p class="harga">Rp750.000 / orang</p>
                    </div>
                </article>

                <article class="kartu-paket">
                    <img src="images/imgdieng.jpg" alt="Wisata Dieng">
                    <div class="isi-kartu">
                        <h3>Open Trip Dieng</h3>
                        <p><strong>Durasi:</strong> 2 hari 1 malam</p>
                        <p><strong>Fasilitas:</strong> Transportasi, tiket wisata, makan, pemandu</p>
                        <p class="harga">Rp650.000 / orang</p>
                    </div>
                </article>

                <article class="kartu-paket">
                    <img src="images/imgKarimunjawa.jpg" alt="Wisata Karimunjawa">
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
                <input
                    type="hidden"
                        name="booking_token"
                            value="<?php
                            echo htmlspecialchars(
                            $_SESSION["booking_token"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                            );
                            ?>"
                    >
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

                <button
                    id="submitBooking"
                    class="tombol"
                    type="submit"
                    >
                    Kirim Booking
                </button>
            </form>
        </section>

        <section class="counter">
            <p>Total Pengunjung Website</p>
            <strong><?php echo $totalPengunjung; ?></strong>
        </section>
    </main>

    <footer class="footer-modern">
    <div class="footer-container">
        <div class="footer-profile">
            <h2>IndoExplore</h2>
            <p>
                Temukan pengalaman perjalanan lokal terbaik dan jelajahi
                keindahan Indonesia bersama kami.
            </p>

            <div class="social-media">
                <a href="https://instagram.com/mizani_alriyzqi_"
                   target="_blank"
                   aria-label="Instagram">
                    IG
                </a>

                <a href="https://github.com/mizanialriyzqi"
                   target="_blank"
                   aria-label="GitHub">
                    GH
                </a>

                <a href="https://wa.me/6285783733273"
                   target="_blank"
                   aria-label="WhatsApp">
                    WA
                </a>

                <a href="mailto:email@gmail.com"
                   aria-label="Email">
                    EM
                </a>
            </div>
        </div>

        <div class="footer-menu">
            <h3>Jelajahi</h3>

            <a href="#beranda">Beranda</a>
            <a href="#paket">Paket Wisata</a>
            <a href="#booking">Booking Trip</a>
        </div>

        <div class="footer-developer">
            <h3>Developer</h3>

            <p>Mizani Alriyzqi</p>
            <p>Informatika</p>
            <p>Universitas Ahmad Dahlan</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>
            Dibuat dengan semangat eksplorasi oleh
            <strong>Mizani Alriyzqi</strong>
        </p>

        <p>&copy; 2026 IndoExplore. All rights reserved.</p>
    </div>
</footer>

    <script src="script.js"></script>
</body>
</html>
