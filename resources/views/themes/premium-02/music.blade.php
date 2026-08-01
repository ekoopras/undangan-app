@php
$sections = $invitation->features['sections'] ?? [];

// Cari section yang type-nya 'music'
$musicSection = collect($sections)->firstWhere('type', 'music') ?? [];

// Ambil nilai 'music_url', jika tidak ada di database maka bernilai NULL
$audioUrl = $musicSection['music_url'] ?? null;
@endphp

<!-- Container Tombol Musik (Default: HIDDEN agar tidak terlihat di cover) -->
<div id="music-widget" class="fixed bottom-5 right-5 z-50 hidden">
    <!-- Element Audio HTML5 -->
    <audio id="bg-music" loop preload="auto">
        <source src="{{ $audioUrl }}" type="audio/mpeg">
        Browser Anda tidak mendukung elemen audio.
    </audio>

    <!-- Tombol Hidup / Mati Musik -->
    <button id="music-btn"
        onclick="toggleMusic()"
        type="button"
        aria-label="Toggle Music"
        class="flex items-center justify-center w-9 h-9 bg-[#e6ddd7] backdrop-blur-md rounded-full shadow-xl border border-gray-200 text-gray-700 hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none">

        <!-- Icon Musik (Berputar saat hidup) -->
        <svg id="icon-play" class="w-6 h-6 text-black animate-spin-slow hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>

        <!-- Icon Mute / Mati -->
        <svg id="icon-mute" class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
        </svg>
    </button>
</div>

<style>
    @keyframes spinSlow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spinSlow 4s linear infinite;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const widget = document.getElementById('music-widget');
        const audio = document.getElementById('bg-music');
        const iconPlay = document.getElementById('icon-play');
        const iconMute = document.getElementById('icon-mute');

        let isPlaying = false;
        let wasPlayingBeforeHidden = false; // Menyimpan status sebelum keluar dari browser

        // 1. Fungsi Global yang dipanggil saat tombol Buka Undangan di-klik
        window.playMusicFromCover = function() {
            widget.classList.remove('hidden');

            if (!isPlaying) {
                audio.play().then(() => {
                    isPlaying = true;
                    iconPlay.classList.remove('hidden');
                    iconMute.classList.add('hidden');
                }).catch((err) => {
                    console.log('Playback ditahan:', err);
                });
            }
        };

        // 2. Fungsi Manual Toggle On/Off Tombol
        window.toggleMusic = function() {
            if (isPlaying) {
                audio.pause();
                iconPlay.classList.add('hidden');
                iconMute.classList.remove('hidden');
                isPlaying = false;
            } else {
                audio.play().then(() => {
                    iconPlay.classList.remove('hidden');
                    iconMute.classList.add('hidden');
                    isPlaying = true;
                }).catch((err) => console.log('Playback error:', err));
            }
        };

        // 3. 🚀 FITUR BARU: Deteksi saat user keluar / pindah dari browser
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Jika user keluar dari tab/browser/minimize HP:
                if (isPlaying) {
                    wasPlayingBeforeHidden = true; // Catat bahwa musik sebelumnya menyala
                    audio.pause();
                    isPlaying = false;

                    // Update tampilan ikon jadi Mute
                    iconPlay.classList.add('hidden');
                    iconMute.classList.remove('hidden');
                }
            } else {
                // Jika user kembali lagi membuka browser:
                if (wasPlayingBeforeHidden) {
                    audio.play().then(() => {
                        isPlaying = true;
                        wasPlayingBeforeHidden = false;

                        // Update tampilan ikon jadi Play
                        iconPlay.classList.remove('hidden');
                        iconMute.classList.add('hidden');
                    }).catch((err) => console.log('Autoplay resume error:', err));
                }
            }
        });
    });
</script>