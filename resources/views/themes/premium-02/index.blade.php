@extends('themes.layout.app')

@section('content')

<div class="w-full h-full overflow-y-scroll snap-y snap-mandatory no-scrollbar relative">

    <div class="fixed inset-0 max-w-md mx-auto bg-cover bg-center bg-no-repeat z-0 pointer-events-none"
        style="background-image: radial-gradient(circle, #3f4a51 0%, #141b22 100%);">
        <div class="absolute -inset-2 bg-cover bg-center pointer-events-none z-10 ani-float"
            style="background-image: url('{{ asset('themes/premium-02/bg.png') }}');"></div>
    </div>
    <div class="relative z-10 w-full h-full">
        @include('themes.premium-02.loading')
        @include('themes.premium-02.cover')
        @include('themes.premium-02.opening')
        @include('themes.premium-02.mempelai-pria')
        @include('themes.premium-02.mempelai-wanita')
        @include('themes.premium-02.acara')
        @include('themes.premium-02.maps')
        @include('themes.premium-02.gift')
        @include('themes.premium-02.terimakasih')
        @include('themes.premium-02.ucapan')
        @include('themes.premium-02.music')

    </div>

</div>

@endsection