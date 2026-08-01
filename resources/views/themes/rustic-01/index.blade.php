@extends('themes.layout.app')

@section('content')

<div class="w-full max-w-md min-h-screen shadow-2xl relative overflow-y-auto no-scrollbar pb-20">

    @include('themes.rustic-01.cover')
    @include('themes.rustic-01.opening')
    @include('themes.rustic-01.quotes')
    @include('themes.rustic-01.mempelai')
    @include('themes.rustic-01.acara')
    @include('themes.rustic-01.maps')
    @include('themes.rustic-01.ucapan')
    @include('themes.rustic-01.gift')
    @include('themes.rustic-01.terimakasih')
    @include('themes.rustic-01.nav')

</div>

@endsection