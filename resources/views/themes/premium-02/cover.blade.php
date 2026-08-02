@php
// Cari data seksi 'cover' di dalam array sections
$sections = $invitation->features['sections'] ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

// Ambil path gambar
$pathSampul = $coverData['cover_gambar_sampul'] ?? null;
$pathAvatar = $coverData['cover_gambar_avatar'] ?? null;

// Convert ke URL Storage
$sampulUrl = !empty($pathSampul)
? \Illuminate\Support\Facades\Storage::url($pathSampul)
: 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600';

$avatarUrl = !empty($pathAvatar)
? \Illuminate\Support\Facades\Storage::url($pathAvatar)
: null;

// Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';
@endphp

<section id="cover-screen"
    class="fixed inset-y-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-cover bg-center z-50 flex flex-col justify-between items-center text-center p-8 transition-all duration-700 ease-in-out overflow-y-auto"
    style="background-image: url('{{ $sampulUrl }}');">

    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-black/20 pointer-events-none z-0 [mask-image:linear-gradient(to_bottom,transparent_10%,black_100%)]"></div>

    <!-- Bagian Atas: Avatar & Header Undangan -->
    <div class="mt-3 text-[#EFEAE2] flex flex-col items-center">

    </div>

    {{-- Kondisional Gambar Avatar (Hanya muncul jika ada) --}}
    @if($avatarUrl)
    <div class="mt-[4rem] relative">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-2 border-[#E6DDD7]/80 p-1 shadow-xl bg-black/20 backdrop-blur-sm overflow-hidden">
            <img src="{{ $avatarUrl }}" alt="Avatar Mempelai" class="w-full h-full object-cover rounded-full">
        </div>
    </div>
    @endif

    <!-- Wrapper Utama Bagian Bawah -->
    <div class="font-poppins w-full px-6 mb-3 flex flex-col items-center text-center z-10 space-y-6">

        <!-- Group Teks Kepada Yth & Nama Tamu -->
        <div class="flex flex-col items-center justify-center gap-1.5">
            <h2 class="font-alex text-[2.5rem] text-white font-bold leading-relaxed">
                <span>{{ $pria }}</span>
                <img src="{{ asset('themes/premium-02/frame.png') }}" alt="&" class="h-[60px] w-auto inline-block object-contain" />
                <span>{{ $wanita }}</span>
            </h2>

            <p class="text-[12px] text-white tracking-wide">
                Kepada Yth.
            </p>

            <h1 class="text-[15px] font-bold text-white capitalize drop-shadow-sm">
                {{ request('to') ?? 'Tamu Undangan' }}
            </h1>
        </div>

        <!-- Tombol Buka Undangan -->
        <div class="w-full flex justify-center pt-2">
            <button onclick="bukaUndangan(); playMusicFromCover();"
                class="w-[60%] max-w-xs py-3 bg-[#374049] text-[#fff] text-xs font-bold uppercase rounded-full shadow-lg transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 animate-bounce cursor-pointer tracking-wider">
                <span>Buka Undangan</span>
            </button>
        </div>

    </div>
</section>

<script>
    function bukaUndangan() {
        const cover = document.getElementById('cover-screen');
        const nav = document.getElementById('bottom-nav');

        if (nav) {
            nav.classList.remove('hidden');
        }

        cover.classList.add('-translate-y-full', 'opacity-0');
        document.body.classList.remove('overflow-hidden');

        setTimeout(() => {
            cover.remove();
        }, 700);

        const coverPage = document.getElementById('cover-page');
        if (coverPage) coverPage.classList.add('-translate-y-full');

        const openingSection = document.getElementById('opening');
        if (openingSection) {
            openingSection.classList.add('play-anim');
        }
    }
</script>