import axios from "axios";

document
    .getElementById("signForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const fileInput = document.getElementById("file");
        const passphraseInput = document.getElementById("passphrase");
        const notif = document.getElementById("notif");

        // Reset notifikasi
        notif.classList.add("hidden");
        notif.textContent = "";

        // Validasi input
        const file = fileInput.files[0];
        if (!file)
            return showNotif("Silakan pilih dokumen terlebih dahulu.", "error");
        if (file.size > 5 * 1024 * 1024)
            return showNotif(
                "Ukuran file terlalu besar. Maksimal 5 MB.",
                "error"
            );

        const passphrase = passphraseInput.value.trim();
        if (!passphrase)
            return showNotif("Passphrase tidak boleh kosong.", "error");

        // Kirim data ke API
        const formData = new FormData();
        formData.append("signed_file", file);
        formData.append("passphrase", passphrase);

        showNotif("Mengirim data...", "loading");

        try {
            const response = await axios.post("/sign-dokumen-no-qr", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            });

            // Tampilkan sukses
            showNotif(
                response.data.message || "Dokumen berhasil ditandatangani!",
                "success"
            );

            // Ambil id_dokumen (sesuaikan struktur respons server kamu)
            const id_dokumen = response.data.data.data.id_dokumen[0];
            if (id_dokumen) createSaveForm(id_dokumen);
        } catch (error) {
            if (error.response) {
                showNotif(
                    error.response.data.message ||
                        "Gagal menandatangani dokumen.",
                    "error"
                );
            } else if (error.request) {
                showNotif(
                    "Tidak dapat terhubung ke server. Coba lagi nanti.",
                    "error"
                );
            } else {
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

// ---------------------------------------------------------
// Fungsi untuk membuat form input nama_file setelah sukses
// ---------------------------------------------------------
function createSaveForm(id_dokumen) {
    // Hapus form sebelumnya jika ada
    const existingForm = document.getElementById("signForm");
    if (existingForm) existingForm.remove();

    // Buat elemen form
    const form = document.createElement("form");
    form.id = "saveForm";
    form.className = "mt-6 flex flex-col gap-3";

    // Input nama file
    const input = document.createElement("input");
    input.type = "text";
    input.name = "nama_file";
    input.placeholder = "Masukkan nama file";
    input.required = true;
    input.className = "border rounded px-3 py-2";

    // Tombol simpan
    const button = document.createElement("button");
    button.type = "submit";
    button.textContent = "Simpan";
    button.className =
        "bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700";

    // Notifikasi simpan
    const saveNotif = document.createElement("div");
    saveNotif.id = "saveNotif";
    saveNotif.className = "hidden";

    form.appendChild(input);
    form.appendChild(button);
    form.appendChild(saveNotif);

    // Tambahkan ke DOM setelah notifikasi utama
    const notif = document.getElementById("notif");
    notif.parentNode.insertBefore(form, notif.nextSibling);

    // Event submit untuk menyimpan nama file
    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const nama_file = input.value.trim();
        if (!nama_file) {
            saveNotif.className =
                "mt-2 text-sm text-red-700 bg-red-100 border border-red-300 p-2 rounded";
            saveNotif.textContent = "Nama file tidak boleh kosong.";
            return;
        }

        saveNotif.className =
            "mt-2 text-sm text-blue-700 bg-blue-100 border border-blue-300 p-2 rounded";
        saveNotif.textContent = "Menyimpan dan menyiapkan unduhan...";

        try {
            // ✅ Gunakan responseType: 'blob' untuk menerima file biner
            const res = await axios.post(
                "/download-and-simpan",
                {
                    id_dokumen: id_dokumen,
                    nama_file: nama_file,
                },
                { responseType: "blob" } // <=== penting!
            );

            // ✅ Ambil nama file dari header atau gunakan default
            const contentDisposition = res.headers["content-disposition"];
            let filename = nama_file + ".pdf";

            if (contentDisposition) {
                const match = contentDisposition.match(/filename="?([^"]+)"?/);
                if (match && match[1]) {
                    filename = match[1]
                        .replace(/['"]/g, "") // hapus kutip
                        .replace(/_+$/, "") // hapus underscore di akhir
                        .trim(); // hapus spasi sisa
                }
            }

            // ✅ Buat link download dari blob response
            const blob = new Blob([res.data], { type: "application/pdf" });
            const url = window.URL.createObjectURL(blob);

            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", filename);
            document.body.appendChild(link);
            link.click();
            link.remove();

            // ✅ Update notifikasi sukses
            saveNotif.className =
                "mt-2 text-sm text-green-700 bg-green-100 border border-green-300 p-2 rounded";
            saveNotif.textContent = "Nama file disimpan dan unduhan dimulai.";

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } catch (err) {
            saveNotif.className =
                "mt-2 text-sm text-red-700 bg-red-100 border border-red-300 p-2 rounded";
            saveNotif.textContent =
                err.response?.data?.message ||
                "Gagal menyimpan atau mengunduh file.";
        }
    });
}
