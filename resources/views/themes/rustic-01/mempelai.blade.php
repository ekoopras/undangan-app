<section id="mempelai" class="py-16 px-6 text-center bg-[#F9F6F0]">
    <h2 class="font-serif-elegant text-xl tracking-widest text-[#705C4E] mb-8 uppercase font-semibold">Kedua Mempelai</h2>

    <div class="space-y-8">
        <div class="p-6 bg-white rounded-2xl border border-[#EFEAE2] shadow-sm">
            <h3 class="font-cursive text-3xl text-[#705C4E] mb-1">{{ $invitation->features['mempelai_pria'] ?? 'Nama Pria' }}</h3>
            <p class="text-xs text-gray-500 italic">Putra dari Pasangan Bapak X & Ibu Y</p>
        </div>

        <span class="font-serif-elegant text-lg text-[#8C7A6B] block">&</span>

        <div class="p-6 bg-white rounded-2xl border border-[#EFEAE2] shadow-sm">
            <h3 class="font-cursive text-3xl text-[#705C4E] mb-1">{{ $invitation->features['mempelai_wanita'] ?? 'Nama Wanita' }}</h3>
            <p class="text-xs text-gray-500 italic">Putri dari Pasangan Bapak A & Ibu B</p>
        </div>
    </div>
</section>