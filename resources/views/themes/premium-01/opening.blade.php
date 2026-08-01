@php
$sections = $invitation->features['sections'] ?? [];
$openingData = collect($sections)->firstWhere('type', 'opening') ?? [];

// Ambil path gambar
$pathAvatar = $openingData['opening_gambar_avatar'] ?? null;

$avatarUrl = !empty($pathAvatar)
? \Illuminate\Support\Facades\Storage::url($pathAvatar)
: null;

// Nama Mempelai
$pria = $openingData['opening_mempelai_pria'] ?? 'Pria';
$wanita = $openingData['opening_mempelai_wanita'] ?? 'Wanita';

//Tanggal
$tglresepsi = $openingData['opening_tanggal_resepsi'] ?? null;
@endphp

<section id="opening" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- STYLE ANIMASI KUSTOM (Menunggu class .play-anim aktif) -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Animasi berjalan jika class .play-anim menempel langsung di elemen #opening */
        #opening.play-anim .anim-fade-up {
            animation: fadeInUp 1s ease-out forwards;
        }

        #opening.play-anim .anim-scale {
            animation: scaleIn 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>

    <!-- 1. BAGIAN ATAS (Judul) -->
    <div class="w-full pt-2 anim-fade-up" style="animation-delay: 0.2s; opacity: 0;">
        <h1 class="font-gurajada uppercase text-5xl font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
            The Wedding Of
        </h1>
    </div>

    <!-- 2. BAGIAN TENGAH (Foto & Ring) -->
    <div class="relative w-72 h-72 flex items-center justify-center my-auto anim-scale" style="animation-delay: 0.4s; opacity: 0;">
        <div class="w-[160px] h-[160px] rounded-full overflow-hidden bg-stone-200 z-0 shadow-md">
            <img src="{{ $avatarUrl }}" alt="Foto Bulat" class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
            <img src="{{ asset('themes/premium-01/ring.png') }}" alt="Ring" class="w-full h-full object-contain drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)] animate-pulse" style="animation-duration: 3s;">
        </div>
    </div>

    <!-- 3. BAGIAN BAWAH (Nama, Tanggal, & Countdown) -->
    <div class="w-full space-y-4">

        <!-- Nama Mempelai -->
        <div class="anim-fade-up" style="animation-delay: 0.6s; opacity: 0;">
            <h1 class="font-hurricane text-[50px] font-bold tracking-wide text-[#0c4643] flex items-center justify-center gap-3 drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
                {{ $pria }}
                <span class="font-alex text-4xl md:text-5xl lowercase mx-1">&</span>
                {{ $wanita }}
            </h1>
        </div>

        <!-- Info Tanggal -->
        <div class="anim-fade-up" style="animation-delay: 0.8s; opacity: 0;">
            <p class="font-inter text-xs text-[#0c4643]">
                Akan Menyelenggarakan Acara Pernikahan Pada
            </p>
            <p class="font-inter text-[18px] font-bold tracking-widest text-[#0c4643] mt-2">
                {{ \Carbon\Carbon::parse($invitation->sections_data['opening']['opening_tanggal_resepsi'] ?? now())->locale('id')->translatedFormat('d F Y') }}
            </p>
        </div>

        <!-- Countdown -->
        <div id="countdown" class="flex gap-2.5 justify-center items-center pt-2 select-none anim-fade-up"
            data-target="{{ $tglresepsi }}"
            style="animation-delay: 1s; opacity: 0;">

            <div class="w-14 h-14 bg-[#0c4643] text-amber-200 border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="days" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-stone-300/80 mt-1 font-medium leading-none">Hari</span>
            </div>

            <div class="w-14 h-14 bg-[#0c4643] text-amber-200 border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="hours" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-stone-300/80 mt-1 font-medium leading-none">Jam</span>
            </div>

            <div class="w-14 h-14 bg-[#0c4643] text-amber-200 border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="minutes" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-stone-300/80 mt-1 font-medium leading-none">Menit</span>
            </div>

            <div class="w-14 h-14 bg-[#0c4643] text-amber-200 border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="seconds" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-stone-300/80 mt-1 font-medium leading-none">Detik</span>
            </div>

        </div>

    </div>

    <script>
        // Daftarkan fungsi pemantau setelah dokumen siap
        document.addEventListener("DOMContentLoaded", function() {
            const openingSection = document.getElementById('opening');

            // Pengaturan deteksi: pemicu aktif ketika minimal 30% area seksi terlihat di layar
            const observerOptions = {
                root: null,
                threshold: 0.3
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    // Jika pengguna masuk ke area seksi opening
                    if (entry.isIntersecting) {
                        // Pastikan efek hanya berjalan setelah cover dibuka (opsional perlindungan)
                        const coverScreen = document.getElementById('cover-screen');
                        if (!coverScreen) {
                            openingSection.classList.add('play-anim');
                        }
                    } else {
                        // Jika seksi opening ditinggalkan/di-scroll ke bawah, hapus class untuk me-reset animasi
                        openingSection.classList.remove('play-anim');
                    }
                });
            }, observerOptions);

            // Mulai memantau seksi opening
            if (openingSection) {
                observer.observe(openingSection);
            }
        });
    </script>

</section>