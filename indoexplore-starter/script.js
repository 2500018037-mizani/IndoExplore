const formBooking = document.getElementById("formBooking");

const openingIntro = document.getElementById("openingIntro");
const enterWebsite = document.getElementById("enterWebsite");



if (openingIntro && enterWebsite) {
    const introSudahDibuka =
        sessionStorage.getItem("introSudahDibuka");

    if (introSudahDibuka === "ya") {
        openingIntro.style.display = "none";
    } else {
        document.body.classList.add("intro-active");
    }

    enterWebsite.addEventListener("click", function () {
        openingIntro.classList.add("hide-opening");
        document.body.classList.remove("intro-active");

        sessionStorage.setItem("introSudahDibuka", "ya");

        setTimeout(function () {
            openingIntro.style.display = "none";
        }, 1200);
    });
}


if (formBooking) {
    formBooking.addEventListener("submit", function (event) {
        const nama =
            document.getElementById("nama").value.trim();

        const whatsapp =
            document.getElementById("whatsapp").value.trim();

        const destinasi =
            document.getElementById("destinasi").value;

        const jumlah =
            document.getElementById("jumlah").value;

        const errorNama =
            document.getElementById("errorNama");

        const errorWhatsapp =
            document.getElementById("errorWhatsapp");

        const errorDestinasi =
            document.getElementById("errorDestinasi");

        const errorJumlah =
            document.getElementById("errorJumlah");

        errorNama.textContent = "";
        errorWhatsapp.textContent = "";
        errorDestinasi.textContent = "";
        errorJumlah.textContent = "";

        let adaKesalahan = false;

        if (nama === "") {
            errorNama.textContent =
                "Nama pemesan wajib diisi.";

            adaKesalahan = true;
        }

        const polaWhatsapp = /^[0-9]{10,}$/;

        if (!polaWhatsapp.test(whatsapp)) {
            errorWhatsapp.textContent =
                "Nomor WhatsApp harus berupa angka dan minimal 10 digit.";

            adaKesalahan = true;
        }

        if (destinasi === "") {
            errorDestinasi.textContent =
                "Silakan pilih destinasi wisata.";

            adaKesalahan = true;
        }

        if (jumlah === "" || Number(jumlah) < 1) {
            errorJumlah.textContent =
                "Jumlah peserta minimal 1 orang.";

            adaKesalahan = true;
        }

        if (adaKesalahan) {
    event.preventDefault();
    return;
}

const submitBooking =
    document.getElementById("submitBooking");

submitBooking.disabled = true;
submitBooking.textContent = "Menyimpan...";
    });
}
