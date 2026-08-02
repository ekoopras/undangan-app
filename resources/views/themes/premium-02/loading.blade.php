<!-- PRELOADER ANIMATION -->
<div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-stone-900 transition-opacity duration-700 ease-out">
    <div class="flex flex-col items-center space-y-4">
        <!-- Ring Memutar -->
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-2 border-white/20 border-t-white animate-spin"></div>
            <!-- Icon Hati -->
            <svg class="w-6 h-6 text-white/80 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>

        <!-- Teks Memuat -->
        <p class="font-poppins text-xs tracking-widest text-white/70 uppercase animate-pulse">
            Memuat Undangan...
        </p>
    </div>
</div>

<!-- SCRIPT PENGHILANG PRELOADER -->
<script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                preloader.remove();
            }, 700);
        }
    });
</script>