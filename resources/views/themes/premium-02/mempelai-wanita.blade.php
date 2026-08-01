@php
$sections = $invitation->features['sections'] ?? [];
$mempelaiData = collect($sections)->firstWhere('type', 'mempelai_wanita') ?? [];

// 1. Ambil path gambar pria & wanita
$pathAvatarWanita = $mempelaiData['avatar_mempelai_wanita'] ?? null;

// 2. Olah URL Storage (jika file ada)
$avatarWanitaUrl = !empty($pathAvatarWanita) ? \Illuminate\Support\Facades\Storage::url($pathAvatarWanita) : null;

// Nama Mempelai
$mempelaiWanita = $mempelaiData['mempelai_wanita'] ?? 'text belom ada';
$ortuWanita = $mempelaiData['ortu_mempelai_wanita'] ?? 'text belom ada';

@endphp

<section id="mempelai" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden bg-cover bg-center" style="background-image: url('{{ $avatarWanitaUrl }}');">
    <div class="absolute -inset-2 bg-cover bg-center pointer-events-none z-10 ani-float"
        style="background-image: url('{{ asset('themes/premium-02/bg.png') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-black/20 pointer-events-none z-0 [mask-image:linear-gradient(to_bottom,transparent_10%,black_100%)]"></div>

    <div class="my-auto w-full max-w-xs space-y-5"></div>

    <!-- Bagian Bawah: Tombol Buka Undangan -->
    <div class="mb-10 w-full px-6 flex flex-col items-center text-center gap-4 z-10">
        <!-- Teks Kepada Yth -->
        <h3 class="font-alex ani-fade-up text-[2.5rem] font-bold text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-none mb-1" style="animation-delay: 0.6s; opacity: 0;">
            {{ $mempelaiWanita }}
        </h3>

        <p class="font-poppins ani-fade-up text-[10px] text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase tracking-widest leading-none mb-1" style="animation-delay: 0.8s; opacity: 0;">
            Anak Dari
        </p>

        <p class="font-poppins ani-fade-up text-xs font-bold text-[#E6DDD7] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]" style="animation-delay: 1s; opacity: 0;">
            {{ $ortuWanita }}
        </p>
    </div>


</section>