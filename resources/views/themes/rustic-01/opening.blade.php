<section id="opening" class="h-screen flex flex-col justify-center items-center text-center p-6 bg-cover bg-center relative" style="background-image: linear-gradient(to bottom, rgba(253, 251, 247, 0.75), rgba(253, 251, 247, 0.95)), url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600');">
    <span class="text-xs uppercase tracking-widest text-[#8C7A6B] font-semibold mb-2">The Wedding Of</span>
    <h1 class="font-cursive text-5xl text-[#705C4E] my-3">
        {{ $invitation->features['mempelai_pria'] ?? 'Pria' }} & {{ $invitation->features['mempelai_wanita'] ?? 'Wanita' }}
    </h1>
    <p class="text-xs text-gray-500 uppercase tracking-widest mt-4">Kepada Bapak/Ibu/Saudara/i:</p>
    <div class="bg-white/80 backdrop-blur-xs px-6 py-3 rounded-xl my-4 border border-[#EFEAE2] min-w-[200px]">
        <span class="font-semibold text-sm text-[#4A3E3D] capitalize">{{ request('to') ?? 'Tamu Undangan' }}</span>
    </div>
    <p class="text-xs text-[#8C7A6B]">Masa Aktif: <span class="font-bold">{{ $invitation->active_until?->format('d M Y') }}</span></p>
</section>