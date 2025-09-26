import * as pdfjsLib from "pdfjs-dist";
import pdfWorker from "pdfjs-dist/build/pdf.worker.mjs?url";
import axios from "axios";

// Set worker
pdfjsLib.GlobalWorkerOptions.workerSrc = pdfWorker;

const input = document.getElementById("pdfInput");
const container = document.getElementById("pdfPreviewContainer");
const previewBox = document.getElementById("pdfPreviewWrapper");

let pdfDoc = null;
let scale = 1.2;

// Upload handler
if (input) {
    input.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file && file.type === "application/pdf") {
            const reader = new FileReader();
            reader.onload = function () {
                const typedarray = new Uint8Array(this.result);

                pdfjsLib.getDocument(typedarray).promise.then((pdf) => {
                    pdfDoc = pdf;
                    container.classList.remove("hidden");

                    // Hapus preview lama
                    previewBox.innerHTML = "";

                    // Render semua halaman
                    for (let i = 1; i <= pdf.numPages; i++) {
                        renderPage(i);
                    }
                });
            };
            reader.readAsArrayBuffer(file);
        }
    });
}

// Render halaman tertentu
function renderPage(num) {
    pdfDoc.getPage(num).then((page) => {
        const viewport = page.getViewport({ scale });

        // Bungkus canvas di container relatif
        const pageWrapper = document.createElement("div");
        pageWrapper.classList.add(
            "relative",
            "inline-block",
            "mb-6",
            "shadow",
            "border",
            "rounded-lg"
        );

        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = viewport.width;
        canvas.height = viewport.height;

        pageWrapper.appendChild(canvas);
        previewBox.appendChild(pageWrapper);

        // Render ke canvas
        page.render({
            canvasContext: ctx,
            viewport: viewport,
        });

        // Klik → pasang QR
        canvas.addEventListener("click", (e) => {
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            console.log(`Klik halaman ${num} di koordinat:`, x, y);

            // Update input tersembunyi
            document.getElementById("page_number").value = num;
            document.getElementById("x_coordinate").value = Math.round(x);
            document.getElementById("y_coordinate").value = Math.round(y);

            pageWrapper.querySelectorAll("img").forEach((img) => img.remove());

            const qr = document.createElement("img");
            qr.src = "/logo/qrcode.png"; // file QR di public
            qr.classList.add("absolute", "w-[80px]", "h-[80px]", "z-40");

            // Posisi relatif ke canvas
            qr.style.left = `${x - 40}px`; // -40 = setengah ukuran QR
            qr.style.top = `${y - 40}px`;

            pageWrapper.appendChild(qr); // ← tempel ke wrapper, bukan canvas
        });
    });
}

document
    .getElementById("saveBtn")
    .addEventListener("click", async function (e) {
        e.preventDefault();

        const fileInput = document.getElementById("pdfInput");
        const passphrase = document.getElementById("passphrase").value.trim();
        const page = document.getElementById("page_number").value;
        const x = document.getElementById("x_coordinate").value;
        const y = document.getElementById("y_coordinate").value;
        const errorMsg = document.getElementById("errorMsg");
        const successMsg = document.getElementById("successMsg");

        // Reset pesan
        errorMsg.classList.add("hidden");
        successMsg.classList.add("hidden");

        // Validasi frontend
        if (!fileInput.files.length) {
            errorMsg.textContent = "Silakan pilih file PDF terlebih dahulu.";
            errorMsg.classList.remove("hidden");
            return;
        }

        const file = fileInput.files[0];
        if (file.type !== "application/pdf") {
            errorMsg.textContent = "File harus berupa PDF.";
            errorMsg.classList.remove("hidden");
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            errorMsg.textContent = "Ukuran file maksimal 5MB.";
            errorMsg.classList.remove("hidden");
            return;
        }

        if (!passphrase) {
            errorMsg.textContent = "Passphrase wajib diisi.";
            errorMsg.classList.remove("hidden");
            return;
        }

        // Buat FormData
        const formData = new FormData();
        formData.append("signed_file", file);
        formData.append("passphrase", passphrase);
        formData.append("page_number", page);
        formData.append("x_coordinate", x);
        formData.append("y_coordinate", y);

        try {
            const response = await axios.post("/sign-dokumen-qr", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });

            if (!response.data.success) {
                errorMsg.textContent =
                    response.data.message || "Gagal menyimpan dokumen.";
                errorMsg.classList.remove("hidden");
            } else {
                successMsg.textContent =
                    "Dokumen berhasil disimpan dan ditandatangani.";
                successMsg.classList.remove("hidden");
            }
        } catch (err) {
            console.error(err);
            errorMsg.textContent =
                err.response?.data?.message ||
                "Terjadi kesalahan koneksi. Silakan coba lagi.";
            errorMsg.classList.remove("hidden");
        }
    });
