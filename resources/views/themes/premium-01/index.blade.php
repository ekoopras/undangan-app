@extends('themes.layout.app')

@section('content')

<div class="w-full h-full overflow-y-scroll snap-y snap-mandatory no-scrollbar relative">

    <div class="fixed inset-0 max-w-md mx-auto bg-cover bg-center bg-no-repeat z-0 pointer-events-none"
        style="background-image: url('{{ asset('themes/premium-01/bg.jpg') }}');">
    </div>

    <div class="relative z-10 w-full h-full">
        @include('themes.premium-01.cover')
        @include('themes.premium-01.opening')
        @include('themes.premium-01.quotes')
        @include('themes.premium-01.mempelai')
        @include('themes.premium-01.gallery')
        @include('themes.premium-01.acara')
        @include('themes.premium-01.maps')
        @include('themes.premium-01.ucapan')
        @include('themes.premium-01.gift')
        @include('themes.premium-01.terimakasih')

    </div>

    @include('themes.premium-01.nav')

</div>

@endsection