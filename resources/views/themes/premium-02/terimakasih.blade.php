@php
$sections = $invitation->features['sections'] ?? [];
$terimakasihData = collect($sections)->firstWhere('type', 'terimakasih') ?? [];
$openingData = collect($sections)->firstWhere('type', 'opening') ?? [];

// Ambil path gambar
$pathAvatar = $terimakasihData['avatar_terimakasih'] ?? null;
$avatarUrl = !empty($pathAvatar)
? \Illuminate\Support\Facades\Storage::url($pathAvatar)
: null;

// Nama Mempelai
$terimakasihText = $terimakasihData['terimakasih_text'] ?? 'text belom ada';
$mempelaiPria = $openingData['opening_mempelai_pria'] ?? 'text belom ada';
$mempelaiWanita = $openingData['opening_mempelai_wanita'] ?? 'text belom ada';

@endphp

<section id="terimakasih" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden bg-cover bg-center" style="background-image: url('{{ $avatarUrl }}');">
    <div class="absolute inset-0 bg-cover bg-center pointer-events-none z-10" style="background-image: url('{{ asset('themes/premium-02/bg.png') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-black/20 pointer-events-none z-0 [mask-image:linear-gradient(to_bottom,transparent_10%,black_100%)]"></div>

    <!-- 1. BAGIAN ATAS (KATA PENUTUP) -->
    <div class="w-full pt-4 max-w-xs flex flex-col items-center relative z-20">

        <!-- Nama Panggilan Kedua Mempelai (Fade Up Delay 100ms) -->
        <div class="w-full pt-2 ani-fade-up">
            <h2 class="font-alex text-[1.7rem] text-white leading-relaxed flex items-center justify-center gap-2">
                <span>{{ $mempelaiPria }}</span>
                <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain" />
                <span>{{ $mempelaiWanita }}</span>
            </h2>
        </div>

        <!-- Ungkapan Terima Kasih Utama (Scale In Delay 200ms) -->
        <h2 class="font-gurajada text-4xl font-bold uppercase text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] tracking-wide ani-scale delay-400">
            Terima Kasih
        </h2>

        <!-- Teks Pesan Ucapan (Fade Up Delay 300ms) -->
        <p class="font-inter text-[11px] leading-relaxed text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] ani-fade-up delay-500">
            {{ $terimakasihText }}
        </p>

        <!-- Simbol Hiasan Garis (Fade In Delay 400ms) -->
        <div class="w-12 h-[1px] bg-white/30 my-2 ani-fade-in delay-600"></div>

    </div>

    <!-- 2. BAGIAN BAWAH (TOMBOL KIRIM UCAPAN) -->
    <div class="mt-auto mb-6 w-full max-w-xs flex flex-col items-center justify-center relative z-20 ani-fade-up delay-700">

        <!-- Tombol Kirim Ucapan dengan Smooth Scroll -->
        <button onclick="scrollToSection('ucapan')"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#374049] text-white rounded-full font-poppins text-xs font-semibold tracking-wider uppercase backdrop-blur-md shadow-lg active:scale-95 transition-all duration-300 cursor-pointer">
            <svg class="w-4 h-4 text-[#E6DDD7]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span>Kirim Ucapan</span>
        </button>

    </div>

</section>

<!-- SCRIPT UNTUK SMOOTH SCROLL -->
<script>
    function scrollToSection(sectionId) {
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
</script>