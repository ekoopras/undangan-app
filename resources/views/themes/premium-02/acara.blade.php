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
<section id="acara" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden bg-cover bg-center">

    <div class="w-full pt-2 ani-fade-up">
        <h2 class="font-alex text-[1.7rem] text-white leading-relaxed">
            <span>{{ $pria }}</span>
            <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain" />
            <span>{{ $wanita }}</span>
        </h2>
    </div>

    <div class="my-auto w-full max-w-sm space-y-8 text-center text-white">
        @foreach($daftarAcara as $item)
        @php
        $carbonDate = !empty($item['tanggal_acara']) ? \Carbon\Carbon::parse($item['tanggal_acara'])->locale('id') : null;
        @endphp

        <div class="flex flex-col items-center space-y-1">
            <!-- 1. Nama Acara -->
            <h3 class="font-gurajada text-[2.3rem] uppercase font-semibold text-white ani-fade-up delay-100">
                {{ $item['nama_acara'] ?? 'Resepsi' }}
            </h3>

            <!-- 2. Hari, Tanggal Bulan Tahun -->
            @if($carbonDate)
            <p class="font-poppins text-base text-white/90 ani-fade-up delay-200">
                {{ $carbonDate->translatedFormat('l, d F Y') }}
            </p>
            @endif

            <!-- 3. Waktu Acara -->
            @if(!empty($item['waktu_acara']))
            <p class="font-poppins text-sm text-white/90 ani-fade-up delay-300">
                Pukul {{ $item['waktu_acara'] }}
            </p>
            @endif

            <!-- 4. Lokasi Acara -->
            @if(!empty($item['lokasi_acara']))
            <p class="font-poppins text-base font-bold text-white pt-2 ani-fade-up delay-400">
                {{ $item['lokasi_acara'] }}
            </p>
            @endif

            <!-- 5. Alamat Acara -->
            @if(!empty($item['alamat']))
            <p class="font-poppins text-xs text-white/80 leading-relaxed max-w-xs ani-fade-up delay-500">
                {{ $item['alamat'] }}
            </p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="w-full h-2"></div>

</section>