@php
$sections = $invitation->features['sections'] ?? [];
$quoteData = collect($sections)->firstWhere('type', 'quote') ?? [];

// Ambil path gambar
$pathAvatar = $quoteData['quote_gambar_avatar'] ?? null;
$avatarUrl = !empty($pathAvatar)
? \Illuminate\Support\Facades\Storage::url($pathAvatar)
: null;

// Nama Mempelai
$quoteText = $quoteData['quote_text'] ?? 'text belom ada';

@endphp

<section id="quotes" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center pt-[50px] pb-[100px] px-[10px] bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <div class="my-auto flex flex-col items-center justify-center max-w-sm w-full space-y-6">

        <div class="w-[50%] h-auto overflow-hidden ani-scale">
            <img src="{{ $avatarUrl }}" alt="Mempelai" class="w-full h-full object-cover">
        </div>

        <div class="px-4 py-2 ani-fade-up delay-300">
            <span class="font-serif text-4xl text-[#0c4643] block leading-none -mb-2">“</span>

            <p class="font-inter text-xs sm:text-sm text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] leading-relaxed font-light italic">
                {{ $quoteText }}
            </p>
        </div>

    </div>

    <div class="w-full h-4"></div>

</section>