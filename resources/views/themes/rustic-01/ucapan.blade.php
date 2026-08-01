<section id="ucapan" class="py-16 px-6 bg-[#FDFBF7]">
    <h2 class="font-serif-elegant text-xl text-center tracking-widest text-[#705C4E] mb-6 uppercase font-semibold">Kirim Ucapan</h2>

    <form id="wish-form" class="space-y-3">
        @csrf
        <input type="text" id="wish-name" name="name" placeholder="Nama Anda" required class="w-full px-4 py-3 text-xs bg-white border border-[#EFEAE2] rounded-xl focus:outline-none focus:border-[#705C4E]">
        <textarea id="wish-message" name="message" placeholder="Berikan ucapan & doa restu..." rows="3" required class="w-full px-4 py-3 text-xs bg-white border border-[#EFEAE2] rounded-xl focus:outline-none focus:border-[#705C4E]"></textarea>
        <button type="submit" class="w-full py-3 bg-[#8C7A6B] text-white text-xs font-medium uppercase tracking-wider rounded-xl hover:bg-[#705C4E] transition-colors">Kirim Doa</button>
    </form>

    <div class="mt-8 space-y-4 max-h-60 overflow-y-auto no-scrollbar" id="wishes-container">
        @foreach($invitation->wishes as $wish)
        <div class="bg-white p-3.5 rounded-xl border border-[#EFEAE2] shadow-sm">
            <div class="flex justify-between items-center mb-1">
                <h4 class="text-xs font-bold text-[#4A3E3D] capitalize">{{ $wish->name }}</h4>
                <span class="text-[10px] text-gray-400">{{ $wish->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">{{ $wish->message }}</p>
        </div>
        @endforeach
    </div>
</section>

<script>
    document.getElementById('wish-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah page reload

        const nameInput = document.getElementById('wish-name');
        const messageInput = document.getElementById('wish-message');
        const tokenInput = document.querySelector('input[name="_token"]');

        // Fallback token agar aman jika @csrf diletakkan di tempat berbeda
        const csrfToken = tokenInput ? tokenInput.value : "{{ csrf_token() }}";

        // Kirim data menggunakan Fetch API Laravel
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
                    // Berhasil disimpan, langsung buat elemen HTML ucapan baru secara instant di atas daftar
                    const container = document.getElementById('wishes-container');
                    const newWishHtml = `
                            <div class="bg-white p-3.5 rounded-xl border border-[#EFEAE2] shadow-sm transition-all duration-500">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="text-xs font-bold text-[#4A3E3D] capitalize">${data.data.name}</h4>
                                    <span class="text-[10px] text-gray-400">${data.data.time || 'Baru saja'}</span>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">${data.data.message}</p>
                            </div>
                        `;
                    container.insertAdjacentHTML('afterbegin', newWishHtml);

                    // Reset form input
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