import axios from "axios";

document
    .getElementById("signForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault(); // mencegah reload halaman

        const fileInput = document.getElementById("file");
        const passphraseInput = document.getElementById("passphrase");
        const notif = document.getElementById("notif");

        // Reset notifikasi
        notif.classList.add("hidden");
        notif.textContent = "";

        // Validasi: cek file terpilih
        const file = fileInput.files[0];
        if (!file) {
            showNotif("Silakan pilih dokumen terlebih dahulu.", "error");
            return;
        }

        // Validasi: cek ukuran file (maks 5 MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotif("Ukuran file terlalu besar. Maksimal 5 MB.", "error");
            return;
        }

        // Validasi: cek passphrase
        const passphrase = passphraseInput.value.trim();
        if (!passphrase) {
            showNotif("Passphrase tidak boleh kosong.", "error");
            return;
        }

        // Kirim data ke API
        const formData = new FormData();
        formData.append("signed_file", file);
        formData.append("passphrase", passphrase);

        showNotif("Mengirim data...", "loading");

        try {
            const response = await axios.post("/sign-dokumen-no-qr", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });

            // Jika sukses
            showNotif(
                response.data.message ||
                    "Dokumen berhasil ditandatangani secara digital!",
                "success"
            );
        } catch (error) {

            if (error.response) {
                // Jika ada respon dari server (misalnya validasi gagal)
                showNotif(
                    error.response.data.message ||
                        "Gagal menandatangani dokumen.",
                    "error"
                );
            } else if (error.request) {
                // Tidak ada respon (masalah jaringan)
                showNotif(
                    "Tidak dapat terhubung ke server. Coba lagi nanti.",
                    "error"
                );
            } else {
                // Error lain (misal error syntax)
                showNotif("Terjadi kesalahan sistem. Coba lagi.", "error");
            }
        }

        // Fungsi tampil notifikasi
        function showNotif(message, type) {
            notif.classList.remove("hidden");
            notif.textContent = message;

            notif.className =
                "mt-4 text-sm text-center p-3 rounded-lg transition-all duration-200 ";

            if (type === "success") {
                notif.classList.add(
                    "bg-green-100",
                    "text-green-700",
                    "border",
                    "border-green-300"
                );
            } else if (type === "error") {
                notif.classList.add(
                    "bg-red-100",
                    "text-red-700",
                    "border",
                    "border-red-300"
                );
            } else if (type === "loading") {
                notif.classList.add(
                    "bg-blue-100",
                    "text-blue-700",
                    "border",
                    "border-blue-300"
                );
            }
        }
    });
