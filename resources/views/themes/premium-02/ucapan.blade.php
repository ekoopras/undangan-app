@php
$sections = $invitation->features['sections'] ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

// Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';

@endphp

<section id="ucapan" class="h-[100dvh] w-full flex flex-col justify-start items-center text-center pt-10 pb-6 px-6 bg-transparent relative snap-start shrink-0 box-border overflow-hidden">

    <!-- 1. HEADER NAMA MEMPELAI -->
    <div class="w-full mb-4">
        <h2 class="font-cursive text-3xl md:text-4xl text-[#E6DDD7] leading-relaxed">
            {{ $pria }} & {{ $wanita }}
        </h2>
    </div>

    <!-- 2. BAGIAN TENGAH (FORMULIR DAN DAFTAR UCAPAN) -->
    <!-- Menggunakan space-y-6 untuk melegakan jarak antara Form dan Daftar Ucapan -->
    <div class="w-full max-w-xs flex flex-col space-y-6 overflow-hidden">

        <!-- FORMULIR PENGIRIMAN -->
        <form id="wish-form" class="space-y-3">
            @csrf
            <!-- Input Nama -->
            <input type="text" id="wish-name" name="name" placeholder="Nama Anda" required
                class="w-full px-4 py-2.5 text-xs bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl focus:outline-none focus:border-white/50 focus:bg-white/20 backdrop-blur-md transition-all">

            <!-- Textarea Pesan -->
            <textarea id="wish-message" name="message" placeholder="Berikan ucapan & doa restu..." rows="2" required
                class="w-full px-4 py-2.5 text-xs bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl focus:outline-none focus:border-white/50 focus:bg-white/20 backdrop-blur-md transition-all resize-none"></textarea>

            <!-- Tombol Kirim Doa -->
            <button type="submit"
                class="w-full py-2.5 bg-[#E6DDD7] hover:bg-white text-[#4A3E3D] text-xs font-bold uppercase tracking-wider rounded-xl active:scale-95 transition-all shadow-md cursor-pointer">
                Kirim Doa
            </button>
        </form>

        <!-- DAFTAR PESAN (SCROLLABLE) -->
        <div class="h-[300px] overflow-y-auto no-scrollbar space-y-3 text-left" id="wishes-container">
            @foreach($invitation->wishes as $wish)
            <div class="bg-white/10 p-3.5 rounded-xl border border-white/15 backdrop-blur-md shadow-sm">
                <div class="flex justify-between items-center mb-1.5">
                    <h4 class="text-[11px] font-bold text-[#E6DDD7] capitalize leading-none tracking-wide">{{ $wish->name }}</h4>
                    <span class="text-[9px] text-white/50 leading-none">{{ $wish->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-[11px] text-white/90 leading-relaxed font-light">{{ $wish->message }}</p>
            </div>
            @endforeach
        </div>

    </div>

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

                    // SINKRONISASI WARNA DENGAN MODEL BLADE
                    const newWishHtml = `
                        <div class="bg-white/10 p-3.5 rounded-xl border border-white/15 backdrop-blur-md shadow-sm transition-all duration-500 transform translate-y-2">
                            <div class="flex justify-between items-center mb-1.5">
                                <h4 class="text-[11px] font-bold text-[#E6DDD7] capitalize leading-none tracking-wide">${data.data.name}</h4>
                                <span class="text-[9px] text-white/50 leading-none">${data.data.time || 'Baru saja'}</span>
                            </div>
                            <p class="text-[11px] text-white/90 leading-relaxed font-light">${data.data.message}</p>
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