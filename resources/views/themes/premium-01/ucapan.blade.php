<section id="ucapan" class="h-[100dvh] w-full flex flex-col justify-between items-center text-center py-12 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. BAGIAN ATAS (JUDUL SECTION) -->
    <div class="w-full pt-2">
        <h2 class="font-cinzel text-xs tracking-[0.3em] text-[#0c4643] drop-shadow-[0_4px_12px_rgba(0,0,0,0.4)] uppercase font-bold">
            Kirim Ucapan
        </h2>
    </div>

    <!-- 2. BAGIAN TENGAH (FORMULIR DAN DAFTAR UCAPAN) -->
    <div class="my-auto w-full max-w-xs flex flex-col space-y-4 overflow-hidden">

        <!-- FORMULIR PENGIRIMAN -->
        <form id="wish-form" class="space-y-2.5">
            @csrf
            <input type="text" id="wish-name" name="name" placeholder="Nama Anda" required
                class="w-full px-4 py-2.5 text-xs bg-white/10 border border-[#0c4643]/20 text-[#0c4643] placeholder-[#0c4643]/60 rounded-xl focus:outline-none focus:border-[#0c4643] focus:bg-white/20 backdrop-blur-md transition-all">

            <textarea id="wish-message" name="message" placeholder="Berikan ucapan & doa restu..." rows="2" required
                class="w-full px-4 py-2.5 text-xs bg-white/10 border border-[#0c4643]/20 text-[#0c4643] placeholder-[#0c4643]/60 rounded-xl focus:outline-none focus:border-[#0c4643] focus:bg-white/20 backdrop-blur-md transition-all resize-none"></textarea>

            <button type="submit"
                class="w-full py-2.5 bg-[#0c4643] text-amber-200 border border-amber-300/10 text-xs font-semibold uppercase tracking-wider rounded-xl active:scale-95 transition-all shadow-md">
                Kirim Doa
            </button>
        </form>

        <!-- DAFTAR PESAN (SCROLLABLE) -->
        <!-- Menggunakan h-44 (176px) agar muat sempurna dalam area grid snapping layar HP -->
        <div class="h-44 overflow-y-auto no-scrollbar space-y-2.5 text-left" id="wishes-container">
            @foreach($invitation->wishes as $wish)
            <div class="bg-white/10 p-3 rounded-xl border border-[#0c4643]/10 backdrop-blur-md shadow-sm">
                <div class="flex justify-between items-center mb-1">
                    <h4 class="text-[11px] font-bold text-[#0c4643] drop-shadow-[0_2px_4px_rgba(0,0,0,0.1)] capitalize leading-none">{{ $wish->name }}</h4>
                    <span class="text-[9px] text-[#0c4643]/70 leading-none">{{ $wish->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-[11px] text-[#0c4643] leading-normal opacity-90">{{ $wish->message }}</p>
            </div>
            @endforeach
        </div>

    </div>

    <!-- 3. BAGIAN BAWAH (SPACER) -->
    <div class="w-full h-2"></div>

</section>

<!-- SCRIPTS UNTUK HANDLE AJAX -->
<script>
    document.getElementById('wish-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const nameInput = document.getElementById('wish-name');
        const messageInput = document.getElementById('wish-message');
        const tokenInput = document.querySelector('input[name="_token"]');
        const csrfToken = tokenInput ? tokenInput.value : "{{ csrf_token() }}";

        fetch("{{ route('invitation.wish', $invitation->slug) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    name: nameInput.value,
                    message: messageInput.value
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('wishes-container');
                    const newWishHtml = `
                            <div class="bg-white/10 p-3 rounded-xl border border-[#0c4643]/10 backdrop-blur-md shadow-sm transition-all duration-500 transform translate-y-2">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="text-[11px] font-bold text-[#0c4643] drop-shadow-[0_2px_4px_rgba(0,0,0,0.1)] capitalize leading-none">${data.data.name}</h4>
                                    <span class="text-[9px] text-[#0c4643]/70 leading-none">${data.data.time || 'Baru saja'}</span>
                                </div>
                                <p class="text-[11px] text-[#0c4643] leading-normal opacity-90">${data.data.message}</p>
                            </div>
                        `;
                    container.insertAdjacentHTML('afterbegin', newWishHtml);

                    nameInput.value = '';
                    messageInput.value = '';
                } else {
                    alert('Gagal menyimpan ucapan: ' + (data.message || 'Error tidak diketahui'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi saat mengirim ucapan.');
            });
    });
</script>