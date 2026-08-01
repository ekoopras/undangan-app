    <!-- ================= JAVASCRIPT COUNTDOWN ================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownEl = document.getElementById('countdown');
            const targetDateStr = countdownEl.getAttribute('data-target');

            if (!targetDateStr) return;

            // Set target waktu ke jam 08:00 pagi di tanggal resepsi (bisa disesuaikan)
            const countDate = new Date(`${targetDateStr}T08:00:00`).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const gap = countDate - now;

                // Jika waktu sudah lewat, set semua ke 00
                if (gap <= 0) {
                    document.getElementById('days').innerText = '00';
                    document.getElementById('hours').innerText = '00';
                    document.getElementById('minutes').innerText = '00';
                    document.getElementById('seconds').innerText = '00';
                    clearInterval(intervalId);
                    return;
                }

                // Kalkulasi matematika waktu
                const second = 1000;
                const minute = second * 60;
                const hour = minute * 60;
                const day = hour * 24;

                const textDay = Math.floor(gap / day);
                const textHour = Math.floor((gap % day) / hour);
                const textMinute = Math.floor((gap % hour) / minute);
                const textSecond = Math.floor((gap % minute) / second);

                // Render ke HTML dengan format 2 digit (menambahkan angka 0 di depan jika < 10)
                document.getElementById('days').innerText = String(textDay).padStart(2, '0');
                document.getElementById('hours').innerText = String(textHour).padStart(2, '0');
                document.getElementById('minutes').innerText = String(textMinute).padStart(2, '0');
                document.getElementById('seconds').innerText = String(textSecond).padStart(2, '0');
            }

            // Jalankan fungsi setiap 1 detik sekali
            const intervalId = setInterval(updateCountdown, 1000);
            updateCountdown(); // Jalankan sekali di awal tanpa menunggu 1 detik pertama
            window.countdownIntervalId = intervalId; // Menyimpan ID interval jika nanti diperlukan reset ketika pindah page async
        });
    </script>