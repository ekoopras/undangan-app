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

<section id="opening" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden bg-cover bg-center" style="background-image: url('{{ $avatarUrl }}');">

    <div class="absolute -inset-2 bg-cover bg-center pointer-events-none z-10 ani-float"
        style="background-image: url('{{ asset('themes/premium-02/bg.png') }}');"></div>

    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-black/20 pointer-events-none z-0 [mask-image:linear-gradient(to_bottom,transparent_10%,black_100%)]"></div>

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
        .anime-fade-up {
            animation: fadeInUp 1s ease-out forwards;
        }

        #opening.play-anim .anim-fade-up {
            animation: fadeInUp 1s ease-out forwards;
        }

        #opening.play-anim .anim-scale {
            animation: scaleIn 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>

    <!-- 1. BAGIAN ATAS (Judul) -->
    <div class=" w-full pt-2">
        <h1 class="font-gurajada uppercase text-5xl font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">

        </h1>
    </div>


    <!-- 3. BAGIAN BAWAH (Nama, Tanggal, & Countdown) -->
    <div class="w-full space-y-4">

        <!-- Nama Mempelai -->
        <div class="anim-fade-up" style="animation-delay: 0.6s; opacity: 0;">
            <h1 class="font-alex text-[40px] font-light tracking-wide text-white flex items-center justify-center gap-3 drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
                {{ $pria }}
                <span class="font-alex text-4xl md:text-5xl lowercase mx-1">&</span>
                {{ $wanita }}
            </h1>
        </div>

        <!-- Info Tanggal -->
        <div class="anim-fade-up" style="animation-delay: 0.8s; opacity: 0;">
            <p class="font-poppins text-xs text-[#E6DDD7]">
                Akan Menyelenggarakan Acara Pernikahan Pada
            </p>
            <p class="font-poppins text-[18px] font-bold tracking-widest text-[#E6DDD7] mt-2">
                {{ \Carbon\Carbon::parse($invitation->sections_data['opening']['opening_tanggal_resepsi'] ?? now())->locale('id')->translatedFormat('d F Y') }}
            </p>
        </div>

        <!-- Countdown -->
        <div id="countdown" class="flex gap-2.5 justify-center items-center pt-2 select-none anim-fade-up"
            data-target="{{ $tglresepsi }}"
            style="animation-delay: 1s; opacity: 0;">

            <div class="w-14 h-14 bg-[#E6DDD7] text-[#000] border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="days" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-[#000] mt-1 font-medium leading-none">Hari</span>
            </div>

            <div class="w-14 h-14 bg-[#E6DDD7] text-[#000] border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="hours" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-[#000] mt-1 font-medium leading-none">Jam</span>
            </div>

            <div class="w-14 h-14 bg-[#E6DDD7] text-[#000] border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="minutes" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-[#000] mt-1 font-medium leading-none">Menit</span>
            </div>

            <div class="w-14 h-14 bg-[#E6DDD7] text-[#000] border border-amber-300/20 rounded-xl flex flex-col items-center justify-center shadow-lg backdrop-blur-xs">
                <span id="seconds" class="font-inter text-xl font-bold tracking-tight leading-none">00</span>
                <span class="text-[8px] uppercase tracking-wider text-[#000] mt-1 font-medium leading-none">Detik</span>
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