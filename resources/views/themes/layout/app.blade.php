<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Undangan Pernikahan {{ $invitation->features['mempelai_pria'] ?? 'Pria' }} & {{ $invitation->features['mempelai_wanita'] ?? 'Wanita' }}</title>

    <script src="https://cdn.tailwindcss.com/3.4.15"></script>

    @include('themes.layout.font')
    @include('themes.layout.animation')

    <style>
        html,
        body {
            position: relative;
            height: 100dvh;
            width: 100%;
            overflow: hidden;
            /* Mematikan efek tarik-ulur / membal di iOS */
            overscroll-behavior: none;
            -webkit-overflow-scrolling: auto;
        }

        :target {
            scroll-margin-top: 0;
        }

        html {
            /* Mengunci scroll behavior tetap mulus tanpa distorsi visual */
            scroll-behavior: smooth;
            scroll-padding-top: 0;
        }

        /* Menyembunyikan scrollbar bawaan agar estetis */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="flex justify-center items-center m-0 p-0 overflow-hidden h-[100dvh] w-full">

    <!-- Berikan class w-full, max-w-md, dan h-full pada main agar sinkron dengan index -->
    <main class="w-full max-w-md h-full relative overflow-hidden">
        @yield('content')
    </main>

    @include('themes.layout.countdown')

</body>

</html>