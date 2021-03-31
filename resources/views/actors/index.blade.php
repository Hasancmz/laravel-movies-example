@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="popular-actors mx-12 md:mx-0">
            <h2 class="uppercase tracking-wider text-yellow-600 text-lg font-semibold">Popular Actors</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">  
                @foreach ($popularActors as $actor)
                    <div class="actor mt-8">
                        @if($actor['profile_path'])
                            <a href="{{ route('actors.show', $actor['id']) }}">
                                <img src="{{ 'https://image.tmdb.org/t/p/w235_and_h235_face/' . $actor['profile_path'] }}" alt="profile" class="hover:opacity-75 transition ease-in-out duration-150">
                            </a>
                        @else
                            <a href="{{ route('actors.show', $actor['id']) }}">
                                <img src="{{ 'https://ui-avatars.com/api/?size=235&name=' . $actor['name'] }}" alt="profile" class="hover:opacity-75 transition ease-in-out duration-150">
                            </a>
                        @endif
                        
                        <div class="mt-2">
                            <a href="{{ route('actors.show', $actor['id']) }}" class="block text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
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

        <div class="page-load-status my-8">
            <div class="flex justify-center">
                <p class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</p>
                <p class="infinite-scroll-last text-3xl mt-8 text-yellow-700">End of content</p>
                <p class="infinite-scroll-error">Error</p>
            </div>
            
        </div>

        {{-- <div class="flex justify-around mt-16">
            @if ($previous)
                <a href="/actors/page/{{ $previous }}">Previous</a>
            @else
                <div></div>            
            @endif
            @if ($next)
                <a href="/actors/page/{{ $next }}">Next</a>
            @else
                <div></div>
            @endif
        </div> --}}
    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
<script>
    let elem = document.querySelector('.grid');
    let infScroll = new InfiniteScroll( elem, {
    // options
    path: '/actors/page/@{{#}}',
    append: '.actor',
    //history: false,
    status: '.page-load-status'
    });
</script>
@endsection