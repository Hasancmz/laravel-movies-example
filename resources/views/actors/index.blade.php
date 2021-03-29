@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="popular-actors mx-12 md:mx-0">
            <h2 class="uppercase tracking-wider text-yellow-600 text-lg font-semibold">Popular Actors</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">  
                @foreach ($popularActors as $actor)
                    <div class="actor mt-8">
                        @if($actor['profile_path'])
                            <a href="">
                                <img src="{{ 'https://image.tmdb.org/t/p/w235_and_h235_face/' . $actor['profile_path'] }}" alt="profile" class="hover:opacity-75 transition ease-in-out duration-150">
                            </a>
                        @else
                            <a href="">
                                <img src="{{ 'https://ui-avatars.com/api7?size235&name=' . $actor['name'] }}" alt="profile" class="hover:opacity-75 transition ease-in-out duration-150">
                            </a>
                        @endif
                        
                        <div class="mt-2">
                            <a href="" class="block text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
                            @foreach ($actor['known_for'] as $actorMovie)
                            @if ($actorMovie['media_type'] === 'movie')
                                <div class="text-sm truncate text-gray-400">{{ $actorMovie['title'] }}@if (!$loop->last), @endif</div> 
                            @elseif($actorMovie['media_type'] === 'tv')
                                <div class="text-sm truncate text-gray-400">{{ $actorMovie['name'] }}@if (!$loop->last), @endif</div>
                            @endif
                            @endforeach
                        </div>
                    </div>    
                @endforeach
            </div>    
        </div>
    </div>
@endsection