<style>
    /* ==========================================
       1. DAFTAR KEYFRAMES ENGINE (DITAMBAH BARU)
       ========================================== */
    @keyframes globalFadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes globalScaleIn {
        from {
            opacity: 0;
            transform: scale(0.94);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Animasi Baru 1: Fade In murni */
    @keyframes globalFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Animasi Baru 2: Geser Kiri */
    @keyframes globalSlideLeft {
        from {
            opacity: 0;
            transform: translateX(40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Animasi Bergerak Atas-Bawah (Infinite) */
    @keyframes globalFloatY {

        0%,
        100% {
            transform: scale(1.05) translateY(0);
        }

        50% {
            transform: scale(1.05) translateY(-12px);
            /* Atur tinggi ayunan di sini */
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }




    /* ==========================================
       2. KLAS DASAR EFEK (Kondisi Sembunyi)
       ========================================== */
    .ani-fade-up,
    .ani-scale,
    .ani-fade-in,
    /* Didaftarkan di sini */
    .ani-slide-left {
        /* Didaftarkan di sini */
        opacity: 0;
        will-change: transform, opacity;
    }


    /* ==========================================
       3. PEMICU UTAMA (.active)
       ========================================== */
    .ani-fade-up.active {
        animation: globalFadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .ani-scale.active {
        animation: globalScaleIn 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    /* Pemicu Animasi Baru 1 */
    .ani-fade-in.active {
        animation: globalFadeIn 1.2s ease-out forwards;
    }

    /* Pemicu Animasi Baru 2 */
    .ani-slide-left.active {
        animation: globalSlideLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .ani-float {
        animation: globalFloatY 4s ease-in-out infinite;
        will-change: transform;
    }


    /* ==========================================
       4. VARIASI DELAY
       ========================================== */
    .delay-100 {
        animation-delay: 100ms !important;
    }

    .delay-200 {
        animation-delay: 200ms !important;
    }

    .delay-300 {
        animation-delay: 300ms !important;
    }

    .delay-400 {
        animation-delay: 400ms !important;
    }

    .delay-500 {
        animation-delay: 500ms !important;
    }

    .delay-700 {
        animation-delay: 700ms !important;
    }

    .delay-1000 {
        animation-delay: 1000ms !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Javascript secara otomatis mendeteksi class baru 
        // selama class tersebut diawali dengan "ani-"
        const animatedElements = document.querySelectorAll("[class*='ani-']");

        const elementObserverOptions = {
            root: null,
            threshold: 0.15
        };

        const elementObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const isCoverActive = document.getElementById('cover-screen');

                if (entry.isIntersecting && !isCoverActive) {
                    entry.target.classList.add('active');
                } else {
                    entry.target.classList.remove('active');
                }
            });
        }, elementObserverOptions);

        animatedElements.forEach(el => elementObserver.observe(el));
    });
</script>