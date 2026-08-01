<script>
    // 1. GUDANG FONT: Cukup tambah atau hapus nama font di dalam array ini
    const daftarFont = [
        'Cinzel:wght@400;700',
        'Inter:wght@400;600',
        'Montserrat:wght@400;700',
        'Playfair Display:ital,wght@0,400;0,700;1,400',
        'Sacramento',
        'Great Vibes',
        'Oswald:wght@400;700',
        'Poppins',

        //font-tema-premium-01
        'Gurajada:wght@400',
        'Hurricane:wght@400',

        //font-tema-premium-02
        'Alex Brush',
    ];

    // 2. OTOMATISASI GENERATE LINK GOOGLE FONTS
    const fontQuery = daftarFont.map(font => `family=${font.replace(/ /g, '+')}`).join('&');
    const linkElement = document.createElement('link');
    linkElement.rel = 'stylesheet';
    linkElement.href = `https://fonts.googleapis.com/css2?${fontQuery}&display=swap`;

    // Inject preconnect dan link font ke <head> secara rapi
    document.head.appendChild(Object.assign(document.createElement('link'), {
        rel: 'preconnect',
        href: 'https://fonts.googleapis.com'
    }));
    document.head.appendChild(Object.assign(document.createElement('link'), {
        rel: 'preconnect',
        href: 'https://fonts.gstatic.com',
        crossOrigin: 'anonymous'
    }));
    document.head.appendChild(linkElement);

    // 3. DAFTARKAN SEMUA CLASS FONT CUSTOM KE TAILWIND CDN
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    // Ambil nama depan font sebelum tanda titik dua (:), ubah ke lowercase/kebab-case
                    'alex': ['Alex Brush', 'cursive'],
                    'cinzel': ['Cinzel', 'serif'],
                    'inter': ['Inter', 'sans-serif'],
                    'montserrat': ['Montserrat', 'sans-serif'],
                    'playfair': ['Playfair Display', 'serif'],
                    'sacramento': ['Sacramento', 'cursive'],
                    'great-vibes': ['Great Vibes', 'cursive'],
                    'oswald': ['Oswald', 'sans-serif'],
                    'gurajada': ['Gurajada', 'sans-serif'],
                    'hurricane': ['Hurricane', 'sans-serif'],
                    'poppins': ['Poppins', 'sans-serif'],
                }
            }
        }
    }
</script>