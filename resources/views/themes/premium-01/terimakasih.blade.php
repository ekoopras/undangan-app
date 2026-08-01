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

<section id="terimakasih" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. BAGIAN ATAS (KATA PENUTUP) -->
    <div class="w-full pt-4 max-w-xs">

    </div>

    <!-- 2. BAGIAN TENGAH (SIGNATURE / NAMA PANGGILAN) -->
    <div class="my-auto w-full max-w-xs flex flex-col items-center justify-center space-y-4">

        @if($avatarUrl)
        <div class="w-[120px] h-[120px] rounded-full overflow-hidden mb-3 shadow-md">
            <img src="{{ $avatarUrl }}" alt="Mempelai Pria" class="object-cover">
        </div>
        @endif

        <!-- Ungkapan Terima Kasih Utama -->
        <h2 class="font-gurajada text-4xl font-bold uppercase text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] tracking-wide">
            Terima Kasih
        </h2>

        <p class="font-inter text-[11px] leading-relaxed text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
            {{ $terimakasihText }}
        </p>

        <!-- Simbol Hiasan Kecil (Bisa diganti ornamen mini jika ada) -->
        <div class="w-12 h-[1px] bg-[#0c4643]/30 my-2"></div>

        <!-- Nama Panggilan Kedua Mempelai -->
        <h1 class="font-hurricane text-4.5xl sm:text-5xl font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] flex items-center justify-center gap-2 leading-none">
            {{ $mempelaiPria }}
            <span class="font-alex text-3xl lowercase mx-1">&</span>
            {{ $mempelaiWanita }}
        </h1>

    </div>

</section>