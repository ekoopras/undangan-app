@php
$sections = $invitation->features['sections'] ?? [];
$gallerySection = collect($sections)->firstWhere('type', 'gallery') ?? [];
$daftarFoto = $gallerySection['daftar_foto'] ?? [];
@endphp

<section id="gallery" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. BAGIAN ATAS (KATA PENUTUP) -->
    <div class="w-full pt-4 max-w-xs">

    </div>

    <!-- 2. BAGIAN TENGAH (SIGNATURE / NAMA PANGGILAN) -->
    <div class="my-auto w-full max-w-xs flex flex-col items-center justify-center space-y-4">

        <h3 class="font-serif text-2xl font-bold text-[#0c4643]">Galeri Bahagia</h3>

        <!-- Grid Layout Foto (Responsive: 2 Kolom di Mobile, 3 Kolom di Tablet/Desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @forelse($daftarFoto as $item)
            @if(!empty($item['foto']))
            <div class="relative group overflow-hidden rounded-2xl border border-[#0c4643]/20 shadow-md aspect-square bg-gray-100">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($item['foto']) }}"
                    alt="{{ $item['caption'] ?? 'Foto Undangan' }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    loading="lazy">

                {{-- Overlay Caption jika ada --}}
                @if(!empty($item['caption']))
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-2 text-left">
                    <span class="text-[10px] text-white font-medium line-clamp-2">
                        {{ $item['caption'] }}
                    </span>
                </div>
                @endif
            </div>
            @endif
            @empty
            <p class="col-span-full text-center text-xs text-gray-500 italic">Belum ada foto galeri.</p>
            @endforelse
        </div>

    </div>

</section>