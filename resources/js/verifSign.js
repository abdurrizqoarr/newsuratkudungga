import axios from "axios";

const form = document.getElementById("verifyForm");
const pdfInput = document.getElementById("pdfFile");
const resultDiv = document.getElementById("result");
form.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!pdfInput.files[0]) {
        resultDiv.innerHTML =
            '<p class="text-red-500">Harap pilih file PDF terlebih dahulu.</p>';
        return;
    }

    const file = pdfInput.files[0];

    // Batasi max size 5MB
    if (file.size > 5 * 1024 * 1024) {
        resultDiv.innerHTML =
            '<p class="text-red-500">Ukuran file maksimal 5MB.</p>';
        return;
    }

    const formData = new FormData();
    formData.append("signed_file", file);

    resultDiv.innerHTML = '<p class="text-gray-500">Memverifikasi...</p>';

    try {
        const response = await axios.post(
            `${import.meta.env.VITE_API_TTE}sign/verify`,
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );

        const data = response.data.data;

        let detailsHTML = "";

        if (data.details && data.details.length > 0) {
            detailsHTML = data.details
                .map(
                    (d, i) => `
          <div class="p-3 border rounded-lg bg-gray-50 mb-3">
            <p class="font-semibold text-indigo-700">Tanda Tangan #${i + 1}</p>
            <p><span class="font-medium">Nama Penandatangan:</span> ${
                d.info_signer.signer_name
            }</p>
            <p><span class="font-medium">Issuer:</span> ${
                d.info_signer.issuer_dn
            }</p>
            <p><span class="font-medium">Masa Berlaku Sertifikat:</span> ${
                d.info_signer.signer_cert_validity
            }</p>
            <p><span class="font-medium">Waktu Tanda Tangan:</span> ${
                d.signature_document.signed_in
            }</p>
            <p><span class="font-medium">Integritas Dokumen:</span> 
              ${
                  d.signature_document.document_integrity
                      ? '<span class="text-green-600">Terjamin</span>'
                      : '<span class="text-red-600">Rusak</span>'
              }
            </p>
          </div>
        `
                )
                .join("");
        } else {
            detailsHTML = `<p class="text-gray-500">Tidak ada detail tanda tangan.</p>`;
        }

        resultDiv.innerHTML = `
        <div class="p-4 rounded-lg border ${
            data.jumlah_signature > 0
                ? "border-yellow-300 bg-yellow-50"
                : "border-red-300 bg-red-50"
        }">
          <p class="font-semibold text-lg ${
              data.jumlah_signature > 0 ? "text-yellow-700" : "text-red-700"
          }">
            ${response.data.message}
          </p>
          <p class="mt-2"><span class="font-medium">Nama Dokumen:</span> ${
              data.nama_dokumen
          }</p>
          <p><span class="font-medium">Jumlah Tanda Tangan:</span> ${
              data.jumlah_signature
          }</p>
          <p><span class="font-medium">Catatan:</span> ${data.notes}</p>
          <p><span class="font-medium">Ringkasan:</span> ${data.summary}</p>

          <div class="mt-4">
            <p class="font-semibold text-gray-800">Detail:</p>
            ${detailsHTML}
          </div>
        </div>
      `;
    } catch (error) {
        resultDiv.innerHTML = `
          <div class="p-4 rounded-lg bg-red-50 border border-red-200">
            <p class="font-semibold text-red-700">Gagal:</p>
            <pre class="text-xs text-gray-700 whitespace-pre-wrap mt-2">${
                error.response
                    ? JSON.stringify(error.response.data, null, 2)
                    : error.message
            }</pre>
          </div>
        `;
    }
});
