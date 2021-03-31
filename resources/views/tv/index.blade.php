@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="popular-tv mx-12 md:mx-0">
            <h2 class="uppercase tracking-wider text-yellow-600 text-lg font-semibold">Popular Shows</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">  
                @foreach ($popularShows as $tv)
                    <x-tv-card :tv="$tv" :genres="$genres" />
                @endforeach
            </div>    
        </div>
        <div class="now-playing-tv mx-12 mt-16 md:mx-0">
            <h2 class="uppercase tracking-wider text-yellow-600 text-lg font-semibold">Top Rated Shows</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">  
                @foreach ($topRatedTv as $tv)
                    <x-tv-card :tv="$tv" :genres="$genres" />
                @endforeach
            </div>    
        </div>
    </div>
@endsection