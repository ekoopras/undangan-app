@php
$sections = $invitation->features['sections'] ?? [];
$acaraSection = collect($sections)->firstWhere('type', 'acara') ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

// Ambil array 'daftar_acara' dari dalam section tersebut
$daftarAcara = $acaraSection['daftar_acara'] ?? [];

// Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';

@endphp
<section id="acara" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden bg-cover bg-center">

    <div class="w-full pt-2 ani-fade-up">
        <h2 class="font-alex text-[1.7rem] text-white leading-relaxed">
            <span>{{ $pria }}</span>
            <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain" />
            <span>{{ $wanita }}</span>
        </h2>
    </div>

    <div class="my-auto w-full max-w-sm space-y-3 text-center text-white">
        @foreach($daftarAcara as $item)
        @php
        $carbonDate = !empty($item['tanggal_acara']) ? \Carbon\Carbon::parse($item['tanggal_acara'])->locale('id') : null;
        @endphp

        <div class="flex flex-col items-center">
            <!-- 1. Nama Acara -->
            <h3 class="font-gurajada text-[1.8rem] uppercase font-semibold text-white ani-fade-up delay-100">
                {{ $item['nama_acara'] ?? 'Resepsi' }}
            </h3>

            <!-- 2. Hari, Tanggal Bulan Tahun -->
            @if($carbonDate)
            <p class="font-poppins text-[14px] text-white/90 ani-fade-up delay-200">
                {{ $carbonDate->translatedFormat('l, d F Y') }}
            </p>
            @endif

            <!-- 3. Waktu Acara -->
            @if(!empty($item['waktu_acara']))
            <p class="font-poppins text-[14px] text-white/90 ani-fade-up delay-300">
                Pukul {{ $item['waktu_acara'] }}
            </p>
            @endif

            <!-- 4. Lokasi Acara -->
            @if(!empty($item['lokasi_acara']))
            <p class="font-poppins text-[15px] font-bold text-white pt-2 ani-fade-up delay-400">
                {{ $item['lokasi_acara'] }}
            </p>
            @endif

            <!-- 5. Alamat Acara -->
            @if(!empty($item['alamat']))
            <p class="font-poppins text-[12px] text-white/80 leading-relaxed max-w-xs ani-fade-up delay-500">
                {{ $item['alamat'] }}
            </p>
            @endif

            @if(!empty($item['gmaps']))
            <a href="{{ $item['gmaps'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 px-5 py-2 bg-[#374049] text-white rounded-xl font-inter text-[10px] font-semibold tracking-wider uppercase shadow-md active:scale-95 transition-all ani-fade-up delay-400 mt-[10px]">
                <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Google Maps
            </a>
            @endif

        </div>
        @endforeach
    </div>

    <div class="w-full h-2"></div>

</section>