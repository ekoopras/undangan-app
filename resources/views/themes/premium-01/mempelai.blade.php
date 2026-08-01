@php
$sections = $invitation->features['sections'] ?? [];
$mempelaiData = collect($sections)->firstWhere('type', 'mempelai') ?? [];

// 1. Ambil path gambar pria & wanita
$pathAvatarPria = $mempelaiData['avatar_mempelai_pria'] ?? null;
$pathAvatarWanita = $mempelaiData['avatar_mempelai_wanita'] ?? null;

// 2. Olah URL Storage (jika file ada)
$avatarPriaUrl = !empty($pathAvatarPria) ? \Illuminate\Support\Facades\Storage::url($pathAvatarPria) : null;
$avatarWanitaUrl = !empty($pathAvatarWanita) ? \Illuminate\Support\Facades\Storage::url($pathAvatarWanita) : null;

// Nama Mempelai
$mempelaiText = $mempelaiData['mempelai_text'] ?? 'text belom ada';
$mempelaiPria = $mempelaiData['mempelai_pria'] ?? 'text belom ada';
$ortuPria = $mempelaiData['ortu_mempelai_pria'] ?? 'text belom ada';
$mempelaiWanita = $mempelaiData['mempelai_wanita'] ?? 'text belom ada';
$ortuWanita = $mempelaiData['ortu_mempelai_wanita'] ?? 'text belom ada';

@endphp

<section id="mempelai" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <div class="w-full max-w-xs pb-3">
        <p class="font-inter px-[10%] text-[11px] leading-relaxed text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
            {{ $mempelaiText }}
        </p>
    </div>

    <div class="my-auto w-full max-w-xs space-y-5">

        <div class="flex flex-col items-center">

            @if($avatarPriaUrl)
            <div class="w-[120px] h-[120px] rounded-full overflow-hidden mb-3 shadow-md">
                <img src="{{ $avatarPriaUrl }}" alt="Mempelai Pria" class="object-cover">
            </div>
            @endif

            <h3 class="font-hurricane text-[3rem] font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-none mb-1">
                {{ $mempelaiPria }}
            </h3>

            <p class="font-inter text-[10px] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase tracking-widest leading-none mb-1">
                Anak Dari
            </p>

            <p class="font-inter text-xs font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
                {{ $ortuPria }}
            </p>
        </div>

        <div class="font-alex text-2xl text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-none my-1">&</div>

        <div class="flex flex-col items-center">

            @if($avatarWanitaUrl)
            <div class="w-[120px] h-[120px] rounded-full overflow-hidden mb-3 shadow-md">
                <img src="{{ $avatarWanitaUrl }}" alt="Mempelai Wanita" class="object-cover">
            </div>
            @endif

            <h3 class="font-hurricane text-[3rem] font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-none mb-1">
                {{ $mempelaiWanita }}
            </h3>

            <p class="font-inter text-[10px] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase tracking-widest leading-none mb-1">
                Anak Dari
            </p>

            <p class="font-inter text-xs font-bold text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
                {{ $ortuWanita }}
            </p>
        </div>

    </div>

    <div class="w-full h-2"></div>

</section>