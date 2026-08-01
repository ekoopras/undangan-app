@if(!empty($invitation->features['rekening_gift']))
<section id="gift" class="py-16 px-6 text-center bg-[#F9F6F0]">
    <h2 class="font-serif-elegant text-xl tracking-widest text-[#705C4E] mb-4 uppercase font-semibold">Wedding Gift</h2>
    <p class="text-xs text-gray-500 mb-6">Dompet Digital / Transfer Bank:</p>
    <div class="bg-white border border-dashed border-[#DCD3C9] p-4 rounded-xl inline-block w-full">
        <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold block">No. Rekening</span>
        <span class="text-base font-mono font-bold text-[#4A3E3D] mt-1 block select-all">
            {{ $invitation->features['rekening_gift'] }}
        </span>
    </div>
</section>
@endif