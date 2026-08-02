@php
$sections = $invitation->features['sections'] ?? [];
$giftSection = collect($sections)->firstWhere('type', 'gift') ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

$daftarRekening = $giftSection['daftar_rekening'] ?? [];
// Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';
@endphp

<section id="gift" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. BAGIAN ATAS (JUDUL NAMA MEMPELAI) -->
    <div class="w-full pt-2 ani-fade-up delay-100">
        <h2 class="font-alex text-[1.7rem] text-white leading-relaxed flex items-center justify-center gap-2">
            <span>{{ $pria }}</span>
            <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain transition-transform duration-700 hover:scale-110" />
            <span>{{ $wanita }}</span>
        </h2>
    </div>

    <!-- 2. BAGIAN TENGAH (KARTU ELEKTRONIK & ALAMAT) -->
    <div class="my-auto w-full max-w-xs space-y-5">

        <!-- Pesan Ucapan (Fade Up Delay 200ms) -->
        <p class="font-poppins text-[11px] leading-relaxed text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] px-2 ani-fade-up delay-200">
            Terimakasih telah menambahkan kegembiraan pernikahan kami dengan kehadiran dan hadiah indah Anda.
        </p>

        @forelse($daftarRekening as $index => $item)
        @php
        // Memasukkan delay bertahap untuk tiap kartu (300ms, 400ms, dst)
        $delay = 300 + ($index * 100);
        @endphp

        <!-- KARTU REKENING BANK (Scale/Fade Up Animation) -->
        <div class="p-4 bg-white/10 border border-[#0c4643]/20 rounded-2xl backdrop-blur-md shadow-md flex flex-col items-center transition-all duration-300 hover:bg-white/15 hover:shadow-lg ani-scale delay-{{ $delay }}">

            <!-- Logo Bank / Nama Bank -->
            <span class="font-poppins text-lg font-bold text-white uppercase mb-1">
                {{ $item['nama_bank'] ?? 'Bank' }}
            </span>

            <!-- Nomor Rekening -->
            <p class="font-poppins text-sm font-black text-white tracking-wider mb-1 font-mono" id="norek-{{ $loop->iteration }}">
                {{ $item['no_rekening'] ?? '000000000' }}
            </p>

            <!-- Nama Pemilik Rekening -->
            <p class="font-poppins text-[14px] font-bold text-white uppercase tracking-wide mb-3 opacity-90">
                {{ $item['atas_nama'] ?? '-' }}
            </p>

            <!-- Tombol Salin -->
            <button onclick="copyToClipboard('norek-{{ $loop->iteration }}', this)"
                class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#374049] hover:bg-[#2c333a] text-white rounded-lg font-inter text-[10px] font-semibold tracking-wider uppercase shadow-sm active:scale-90 transition-all duration-200 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                </svg>
                <span>Salin No. Rek</span>
            </button>
        </div>

        @empty
        <p class="text-center text-xs text-gray-400 italic ani-fade-up delay-300">Informasi rekening belum ditambahkan.</p>
        @endforelse

    </div>

    <!-- 3. BAGIAN BAWAH (SPACER) -->
    <div class="w-full h-2"></div>

</section>

<!-- SCRIPT AJIB UNTUK SALIN DENGAN NOTIFIKASI INTERAKTIF & ANIMASI SINKRON -->
<script>
    function copyToClipboard(elementId, button) {
        const text = document.getElementById(elementId).innerText.trim();
        copyText(text, button);
    }

    function copyText(text, button) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="w-3.5 h-3.5 text-amber-300 animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>Berhasil!</span>
            `;
            button.classList.add('bg-emerald-800', 'scale-105');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-emerald-800', 'scale-105');
            }, 2000);
        }).catch(err => {
            console.error('Gagal menyalin teks: ', err);
        });
    }
</script>