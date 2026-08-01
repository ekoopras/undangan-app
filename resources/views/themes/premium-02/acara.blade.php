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
        <h2 class="font-alex text-4xl text-[#E6DDD7] leading-relaxed">
            {{ $pria }} & {{ $wanita }}
        </h2>
    </div>

    <div class="my-auto w-full max-w-sm space-y-8 text-center text-white">
        @foreach($daftarAcara as $item)
        @php
        $carbonDate = !empty($item['tanggal_acara']) ? \Carbon\Carbon::parse($item['tanggal_acara'])->locale('id') : null;
        @endphp

        <div class="flex flex-col items-center">
            <!-- 1. Nama Acara (Fade Up Delay 100ms) -->
            <h3 class="font-gurajada text-4xl text-white capitalize tracking-wide ani-fade-up delay-100">
                {{ $item['nama_acara'] ?? 'Resepsi' }}
            </h3>

            <!-- 2. Section Tanggal (Scale In Delay 200ms) -->
            @if($carbonDate)
            <div class="flex items-center justify-center gap-3 text-white ani-scale delay-200">
                <!-- Hari -->
                <span class="font-poppins text-sm font-semibold tracking-widest uppercase">
                    {{ $carbonDate->translatedFormat('l') }}
                </span>

                <!-- Garis Kiri -->
                <div class="w-[1px] h-8 bg-white/40"></div>

                <!-- Angka Tanggal -->
                <span class="font-poppins text-4xl font-light leading-none px-1">
                    {{ $carbonDate->translatedFormat('d') }}
                </span>

                <!-- Garis Kanan -->
                <div class="w-[1px] h-8 bg-white/40"></div>

                <!-- Bulan & Tahun -->
                <span class="font-poppins text-sm font-semibold tracking-widest uppercase">
                    {{ $carbonDate->translatedFormat('F Y') }}
                </span>
            </div>
            @endif

            <!-- 3. Waktu Acara (Fade Up Delay 300ms) -->
            @if(!empty($item['waktu_acara']))
            <p class="font-poppins text-sm font-medium tracking-wide mt-2 mb-6 ani-fade-up delay-300">
                Pukul {{ $item['waktu_acara'] }}
            </p>
            @endif

            <!-- 4. Lokasi Acara (Fade Up Delay 400ms) -->
            @if(!empty($item['lokasi_acara']))
            <div class="space-y-1 max-w-xs ani-fade-up delay-400">
                <p class="text-[1.2rem] font-medium text-white tracking-wide">
                    {{ $item['lokasi_acara'] }}
                </p>
            </div>
            @endif

            <!-- 5. Alamat Acara (Fade Up Delay 500ms) -->
            @if(!empty($item['alamat']))
            <div class="space-y-1 max-w-xs ani-fade-up delay-500">
                <p class="font-poppins text-sm font-medium tracking-wide mt-2 mb-6 opacity-90">
                    {{ $item['alamat'] }}
                </p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="w-full h-2"></div>

</section>