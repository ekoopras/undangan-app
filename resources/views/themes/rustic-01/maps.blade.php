<section id="maps" class="py-16 px-6 text-center bg-[#F5EFEB]">
    <h2 class="font-serif-elegant text-xl tracking-widest text-[#705C4E] mb-4 uppercase font-semibold">Lokasi Acara</h2>
    <div class="bg-white p-4 rounded-2xl border border-[#E6DDD7] shadow-sm mb-6">
        <p class="text-xs text-gray-700 leading-relaxed whitespace-pre-line mb-4">
            {{ $invitation->features['lokasi_acara'] ?? 'Detail lokasi belum diatur.' }}
        </p>
        @if(!empty($invitation->features['link_maps']))
        <a href="{{ $invitation->features['link_maps'] }}" target="_blank" class="inline-block w-full py-3 bg-[#705C4E] hover:bg-[#5A493E] text-white text-xs font-medium tracking-wider uppercase rounded-xl transition duration-300">
            Buka Google Maps
        </a>
        @endif
</div>
</section>