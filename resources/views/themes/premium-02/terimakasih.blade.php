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
    <div class="w-full pt-4 max-w-xs flex flex-col items-center">

        <!-- Nama Panggilan Kedua Mempelai (Fade Up Delay 100ms) -->
        <h1 class="font-hurricane text-4.5xl sm:text-5xl font-bold text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] flex items-center justify-center gap-2 leading-none ani-fade-up delay-300">
            {{ $mempelaiPria }}
            <span class="font-alex text-3xl lowercase mx-1">&</span>
            {{ $mempelaiWanita }}
        </h1>

        <!-- Ungkapan Terima Kasih Utama (Scale In Delay 200ms) -->
        <h2 class="font-gurajada text-4xl font-bold uppercase text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] tracking-wide ani-scale delay-400">
            Terima Kasih
        </h2>

        <!-- Teks Pesan Ucapan (Fade Up Delay 300ms) -->
        <p class="font-inter text-[11px] leading-relaxed text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] ani-fade-up delay-500">
            {{ $terimakasihText }}
        </p>

        <!-- Simbol Hiasan Garis (Fade In Delay 400ms) -->
        <div class="w-12 h-[1px] bg-white/30 my-2 ani-fade-in delay-600"></div>

    </div>

    <!-- 2. BAGIAN TENGAH (SIGNATURE / NAMA PANGGILAN) -->
    <div class="my-auto w-full max-w-xs flex flex-col items-center justify-center space-y-4">



    </div>

</section>