@php
// Cari data seksi 'cover' di dalam array sections
$sections = $invitation->features['sections'] ?? [];
$coverData = collect($sections)->firstWhere('type', 'cover') ?? [];

// Ambil path gambar
$pathSampul = $coverData['cover_gambar_sampul'] ?? null;

// Convert ke URL Storage + Ubah ke URL Absolut (https://...) agar terbaca WhatsApp
$sampulUrl = !empty($pathSampul)
? url(\Illuminate\Support\Facades\Storage::url($pathSampul))
: 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600';

// Nama Mempelai
$pria = $coverData['cover_mempelai_pria'] ?? 'Pria';
$wanita = $coverData['cover_mempelai_wanita'] ?? 'Wanita';
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Undangan Pernikahan {{ $pria }} & {{ $wanita }}</title>
    <meta name="title" content="Undangan Pernikahan {{ $pria }} & {{ $wanita }}">
    <meta name="description" content="Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan {{ $pria }} & {{ $wanita }}.">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Undangan Pernikahan {{ $pria }} & {{ $wanita }}">
    <meta property="og:description" content="Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan {{ $pria }} & {{ $wanita }}.">

    <!-- Gambar Thumbnail Sampul Spesifik Tema/User Ini -->
    <meta property="og:image" content="{{ $sampulUrl }}">
    <meta property="og:image:secure_url" content="{{ $sampulUrl }}">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">

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