@php
$sections = $invitation->features['sections'] ?? [];
// Cari section yang memilik 'type' === 'acara'
$acaraSection = collect($sections)->firstWhere('type', 'acara') ?? [];

// Ambil array 'daftar_acara' dari dalam section tersebut
$daftarAcara = $acaraSection['daftar_acara'] ?? [];
@endphp
<section id="acara" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <div class="my-auto w-full max-w-xs space-y-6">
        @foreach($daftarAcara as $item)

        <div class="p-5 bg-white/10 border border-[#0c4643]/20 rounded-2xl backdrop-blur-md shadow-md">
            <h3 class="font-gurajada text-3xl font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase leading-none mb-2">
                {{ $item['nama_acara'] ?? 'Acara' }}
            </h3>

            <p class="font-inter text-xs font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] mb-1">
                {{ !empty($item['tanggal_acara']) ? \Carbon\Carbon::parse($item['tanggal_acara'])->locale('id')->translatedFormat('l, d F Y') : '-' }}
            </p>

            <p class="font-inter text-xs font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] mb-1">
                {{ $item['waktu_acara'] ?? '' }}
            </p>

            @if(!empty($item['lokasi_acara']))
            <p class="font-inter text-[11px] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed">
                {{ $item['lokasi_acara'] }}
            </p>
            @endif

            <p class="font-inter text-[11px] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed">
                {{ $item['alamat'] }}
            </p>
        </div>
        @endforeach

    </div>

    <div class="w-full h-2"></div>

</section>