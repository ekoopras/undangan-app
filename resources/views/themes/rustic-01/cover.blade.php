 <section id="cover-screen" class="fixed inset-y-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-cover bg-center z-50 flex flex-col justify-between items-center text-center p-8 transition-all duration-700 ease-in-out"
     style="background-image: linear-gradient(to bottom, rgba(74, 62, 61, 0.6), rgba(74, 62, 61, 0.85)), url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600');">

     <div class="mt-12 text-[#EFEAE2]">
         <span class="text-xs uppercase tracking-widest block opacity-80 mb-2">Walimatul 'Ursy</span>
         <h2 class="font-cursive text-4xl text-[#E6DDD7]">
             {{ $invitation->features['mempelai_pria'] ?? 'Pria' }} & {{ $invitation->features['mempelai_wanita'] ?? 'Wanita' }}
         </h2>
     </div>

     <div class="w-full px-4">
         <p class="text-xs text-[#E6DDD7] uppercase tracking-widest opacity-75 mb-3">Kepada Yth. Bapak/Ibu/Saudara/i:</p>

         <div class="bg-white/10 backdrop-blur-md border border-white/20 py-4 px-6 rounded-2xl shadow-lg inline-block min-w-[240px]">
             <h1 class="text-2xl font-bold text-white tracking-wide capitalize">
                 {{ request('to') ?? 'Tamu Undangan' }}
             </h1>
         </div>

         <p class="text-[11px] text-[#E6DDD7] italic mt-3 opacity-60">*Mohon maaf bila ada kesalahan penulisan nama/gelar</p>
     </div>

     <div class="mb-16 w-full px-6">
         <button onclick="bukaUndangan()" class="w-full py-3.5 bg-[#E6DDD7] hover:bg-white text-[#4A3E3D] text-xs font-bold uppercase tracking-widest rounded-xl shadow-md transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-2 animate-bounce">
             <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
             </svg>
             Buka Undangan
         </button>
     </div>
 </section>

 <script>
     document.body.classList.add('overflow-hidden');

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
     }
 </script>