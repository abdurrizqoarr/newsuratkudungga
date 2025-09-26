<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Pasien</title>
    @vite('resources/css/app.css')
</head>

<body
    class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 h-screen overflow-hidden flex items-center justify-center">
    <input type="hidden" id="dokter_id" value="{{ $dokter }}">
    <input type="hidden" id="poli_id" value="{{ $poli->kd_poli }}">

    <div
        class="w-full max-w-7xl bg-white rounded-3xl shadow-2xl p-8 max-h-screen flex flex-col border border-indigo-100">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 flex-shrink-0">
            <h1 class="text-3xl font-extrabold text-indigo-700">Antrian Pasien {{ $poli->nm_poli }}</h1>
        </div>

        <!-- Scrollable Container -->
        <div id="antrianContainer" class="overflow-y-auto pr-2 space-y-4 scroll2">
            <div class="text-center text-gray-500 py-10">
                <p>Memuat antrian...</p>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('antrianContainer');
        const dokterId = document.getElementById('dokter_id').value;
        const poliId = document.getElementById('poli_id').value;

        // Scroll otomatis
        let direction = 1; // 1 = scroll ke bawah, -1 = scroll ke atas
        const speed = 1; // jarak scroll per step (px)
        const delay = 100; // ms

        // function autoScroll() {
        //     container.scrollTop += direction * speed;
        //     if (container.scrollTop + container.clientHeight >= container.scrollHeight - 1) direction = -1;
        //     else if (container.scrollTop <= 0) direction = 1;
        // }
        
        function autoScroll() {
            container.scrollTop += direction * speed;

            // Jika sudah mencapai bawah, langsung kembali ke atas
            if (container.scrollTop + container.clientHeight >= container.scrollHeight- 1) {
                container.scrollTop = 0;
            }
        }

        setInterval(autoScroll, delay);

        // Fungsi untuk memuat data antrian via AJAX
        async function fetchAntrian() {
            try {
                const response = await fetch(`/jadwal-poli-api?dokter=${dokterId}&poli=${poliId}`);
                const data = await response.json();

                container.innerHTML = '';

                if (data.data.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-gray-500 py-10">
                            <p>Tidak ada pasien dalam antrian.</p>
                        </div>`;
                    return;
                }

                data.data.forEach((item, index) => {
                    const div = document.createElement('div');
                    div.className =
                        'flex items-center bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl p-4 shadow-md';
                    div.innerHTML = `
                        <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center rounded-full bg-white text-indigo-700 font-bold text-6xl shadow">
                            ${index + 1}
                        </div>
                        <div class="ml-4">
                            <p class="text-white font-semibold text-6xl">
                                ${item.nm_pasien}
                            </p>
                        </div>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Gagal memuat antrian:', error);
            }
        }

        // Polling setiap 5 detik
        fetchAntrian(); // load pertama
        setInterval(fetchAntrian, 1000 * 60 * 3);
    </script>
</body>

</html>
