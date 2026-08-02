@php
$sections = $invitation->features['sections'] ?? [];
$mapsData = collect($sections)->firstWhere('type', 'maps') ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

// 1. Definisikan nilai fallback default terlebih dahulu
$defaultEmbed = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.81956135000001!3d-6.1973777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
$defaultLink = 'https://maps.google.com';

// 2. Ambil value dari form Filament dengan fallback variabel yang sudah dibuat
$embedUrl = $mapsData['embed_map_url'] ?? $defaultEmbed;
$linkMaps = $mapsData['link_google_maps'] ?? $defaultLink;

// 3. Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';
@endphp

<section id="maps" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <div class="w-full pt-2 ani-fade-up">
        <h2 class="font-alex text-[1.7rem] text-white leading-relaxed">
            <span>{{ $pria }}</span>
            <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain" />
            <span>{{ $wanita }}</span>
        </h2>
    </div>

    <!-- 2. BAGIAN TENGAH (PETA DAN ALAMAT) -->
    <div class="my-auto w-full max-w-xs flex flex-col items-center space-y-6">

        <!-- Deskripsi Nama Tempat (Fade Up Delay 100ms) -->
        @if(!empty($mapsData['nama_tempat']))
        <h1 class="font-gurajada text-[2rem] font-bold text-white uppercase drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed px-2 ani-fade-up delay-100">
            {{ $mapsData['nama_tempat'] }}
        </h1>
        @endif

        <!-- Frame Iframe Google Maps (Scale In Delay 200ms) -->
        <div class="w-full h-48 rounded-2xl overflow-hidden border border-[#0c4643]/20 shadow-lg relative bg-white/10 backdrop-blur-md p-1 mb-4 [&_iframe]:w-full [&_iframe]:h-full [&_iframe]:rounded-xl [&_iframe]:border-0 ani-scale delay-200">
            {!! $embedUrl !!}
        </div>

        <!-- Deskripsi Alamat Lengkap (Fade Up Delay 300ms) -->
        @if(!empty($mapsData['alamat_lengkap']))
        <p class="font-poppins text-xs text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed px-2 ani-fade-up delay-300">
            {{ $mapsData['alamat_lengkap'] }}
        </p>
        @endif

        <!-- Tombol Buka Google Maps (Fade Up Delay 400ms) -->
        <a href="{{ $linkMaps }}"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#374049] text-white rounded-xl font-inter text-xs font-semibold tracking-wider uppercase shadow-md active:scale-95 transition-all ani-fade-up delay-400">
            <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
            Petunjuk Arah
        </a>

    </div>

    <!-- 3. BAGIAN BAWAH (SPACER) -->
    <div class="w-full h-2"></div>

</section>