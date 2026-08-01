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
    style="background-image: linear-gradient(to bottom, rgba(74, 62, 61, 0.65), rgba(74, 62, 61, 0.85)), url('{{ $sampulUrl }}');">

    <!-- Bagian Atas: Avatar & Header Undangan -->
    <div class="mt-8 text-[#EFEAE2] flex flex-col items-center">

        <span class="text-xs uppercase tracking-widest block opacity-80 mb-2">Walimatul 'Ursy</span>
        <h2 class="font-cursive text-4xl text-[#E6DDD7] leading-relaxed">
            {{ $pria }} & {{ $wanita }}
        </h2>
    </div>

    {{-- Kondisional Gambar Avatar (Hanya muncul jika ada) --}}
    @if($avatarUrl)
    <div class="mt-[4rem] relative">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-2 border-[#E6DDD7]/80 p-1 shadow-xl bg-black/20 backdrop-blur-sm overflow-hidden">
            <img src="{{ $avatarUrl }}" alt="Avatar Mempelai" class="w-full h-full object-cover rounded-full">
        </div>
    </div>
    @endif

    <!-- Bagian Tengah: Nama Tamu Undangan -->
    <div class="w-full px-4 my-auto py-6">
        <p class="text-xs text-[#E6DDD7] uppercase tracking-widest opacity-75 mb-3">Kepada Yth. Bapak/Ibu/Saudara/i:</p>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 py-4 px-6 rounded-2xl shadow-lg inline-block min-w-[240px]">
            <h1 class="text-2xl font-bold text-white tracking-wide capitalize">
                {{ request('to') ?? 'Tamu Undangan' }}
            </h1>
        </div>

        <p class="text-[11px] text-[#E6DDD7] italic mt-3 opacity-60">*Mohon maaf bila ada kesalahan penulisan nama/gelar</p>
    </div>

    <!-- Bagian Bawah: Tombol Buka Undangan -->
    <div class="mb-10 w-full px-6">
        <button onclick="bukaUndangan()"
            class="w-full py-3.5 bg-[#E6DDD7] hover:bg-white text-[#4A3E3D] text-xs font-bold uppercase tracking-widest rounded-xl shadow-md transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-2 animate-bounce">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
            </svg>
            Buka Undangan
        </button>
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