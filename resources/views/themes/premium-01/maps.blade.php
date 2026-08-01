@php
$sections = $invitation->features['sections'] ?? [];
$mapsData = collect($sections)->firstWhere('type', 'maps') ?? [];
// 4. Ambil value dari form Filament (sesuaikan key nama inputan di form kamu)
$embedUrl = $mapsData['embed_map_url'] ?? $defaultEmbed;
$linkMaps = $mapsData['link_google_maps'] ?? $defaultLink;
@endphp

<section id="maps" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. BAGIAN ATAS (JUDUL SECTION) -->
    <div class="w-full pt-2">
        <h2 class="font-cinzel text-xs tracking-[0.3em] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase font-bold">
            Lokasi Acara
        </h2>
    </div>

    <!-- 2. BAGIAN TENGAH (PETA DAN ALAMAT) -->
    <div class="my-auto w-full max-w-xs flex flex-col items-center space-y-6">

        <!-- Deskripsi Alamat Singkat -->
        @if(!empty($mapsData['nama_tempat']))
        <h1 class="font-inter text-xs text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed px-2">
            {{ $mapsData['nama_tempat'] }}
        </h1>
        @endif

        <!-- Frame Iframe Google Maps -->
        <!-- URL Google Maps diambil dari $invitation->features['link_maps'] atau fallback default -->
        <div class="w-full h-48 rounded-2xl overflow-hidden border border-[#0c4643]/20 shadow-lg relative bg-white/10 backdrop-blur-md p-1 mb-4">
            <iframe
                src="{{ $embedUrl }}"
                class="w-full h-full rounded-xl border-0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <!-- Deskripsi Alamat Singkat -->
        @if(!empty($mapsData['alamat_lengkap']))
        <p class="font-inter text-xs text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed px-2">
            {{ $mapsData['alamat_lengkap'] }}
        </p>
        @endif

        <!-- Tombol Buka Google Maps -->
        <a href="{{ $linkMaps }}"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0c4643] text-amber-200 border border-amber-300/20 rounded-xl font-inter text-xs font-semibold tracking-wider uppercase shadow-md active:scale-95 transition-all">
            <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
            Petunjuk Arah
        </a>

    </div>

    <!-- 3. BAGIAN BAWAH (SPACER) -->
    <div class="w-full h-2"></div>

</section>