@extends('layouts.main')

@section('content')
<div class="tvShow-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
        @if ($tvShow['poster_path'])
            <div class="flex-none mx-auto">
                <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $tvShow['poster_path'] }}" alt="poster" class="w-80 lg:w-96">  
            </div>            
        @else
            <div class="flex-none mx-auto">
                <img src="https://via.placeholder.com/350x500" alt="poster" class="w-80 lg:w-96">  
            </div>           
        @endif

        <div class="mx-auto mt-10 md:ml-24">
            <h2 class="text-4xl font-semibold">{{ $tvShow['name'] }}</h2>
            <div class="flex flex-wrap items-center text-gray-400 text-sm" >
                <svg class="fill-current text-yellow-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
                <span class="ml-1">{{ $tvShow['vote_average'] * 10 . '%' }}</span>
                <span class="mx-2">|</span>
                <span>{{ \Carbon\Carbon::parse($tvShow['first_air_date'])->format('M d, Y') }}</span>
                <span class="mx-2">|</span>
                <span>            
                    @foreach ($tvShow['genres'] as $genre)
                        {{ $genre['name'] }} @if (!$loop->last), @endif
                    @endforeach
                </span>
            </div>
            <p class="text-gray-300 mt-8 break-all">{{ $tvShow['overview'] }}</p>
            <div class="mt-12">
                @if ($tvShow['credits']['crew'])
                    <div class="flex mt-4">
                        @foreach ($tvShow['created_by'] as $crew)
                            @if ($loop->index < 2)
                                <div class="mr-8">
                                    <div>{{ $crew['name'] }}</div>
                                    <div class="text-sm text-gray-400">Creator</div>
                                </div>
                            @else
                                @break
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div x-data="{ isOpen: false }">
                @if (count($tvShow['videos']['results']) > 0)
                    <div class="mt-12">
                        <button
                            @click="isOpen = true"
                            class="flex inline-flex items-center bg-yellow-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-yellow-600 transition ease-in-out duration-150"
                        >
                            <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                            <span class="ml-2">Play Trailer</span>
                        </button>
                    </div>
                    <template x-if="isOpen">
                        <div
                            style="background-color: rgba(0, 0, 0, .6);"
                            class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                        >
                            <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                <div class="bg-gray-900 rounded" @click.away="isOpen = false">
                                    <div class="flex justify-end pr-4 pt-2">
                                        <button
                                            @click="isOpen = false"
                                            @keydown.escape.window="isOpen = false"
                                            class="text-3xl leading-none hover:text-gray-300">&times;
                                        </button>
                                    </div>
                                    <div class="modal-body px-8 py-8">
                                        <div class="responsive-container overflow-hidden relative" style="padding-top: 55%">
                                            <iframe 
                                                class="responsive-iframe absolute top-0 left-0 w-full h-full" 
                                                src="https://www.youtube.com/embed/{{ $tvShow['videos']['results'][0]['key'] }}" 
                                                style="border:0;" 
                                                allow="autoplay; encrypted-media" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="tvShow-cast border-b border-gray-800">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-semibold">Cast</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">      
            @foreach ($tvShow['credits']['cast'] as $cast)
            @if ($loop->index < 5)
                <div class="mt-8">
                    @if ($cast['profile_path'])
                        <a href="{{ route('actors.show', $cast['id']) }}">
                            <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $cast['profile_path'] }}" alt="actor1" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
                        </a>  
                    @else
                        <a href="{{ route('actors.show', $cast['id']) }}">
                            <img src="https://via.placeholder.com/190x290" alt="poster" class="">
                        </a>
                    @endif
                    
                    <div class="mt-2">
                        <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray:300">{{ $cast['original_name'] }}</a>
                        <div class="text-sm text-gray-400">
                            {{ $cast['character'] }}
                        </div>
                    </div>
                </div>
            @else
                @break
            @endif
            @endforeach
        </div>
    </div>
</div>

<div class="tvShow-images" x-data="{isOpen: false, image:''}">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-semibold">Images</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($tvShow['images']['backdrops'] as $image)
                @if ($loop->index < 9)
                    <div class="mt-8">
                        <a 
                            @click.prevent="
                                isOpen = true
                                image='{{ 'https://image.tmdb.org/t/p/original/' . $image['file_path'] }}'
                            "
                            href="#" 
                        >
                            <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $image['file_path'] }}" alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                    </div>
                @else
                    @break
                @endif
            @endforeach
        </div>
        <div
            style="background-color: rgba(0, 0, 0, .6);"
            class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
            x-show="isOpen"
        >
            <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                <div class="bg-gray-900 rounded"  @click.away="isOpen = false">
                    <div class="flex justify-end pr-4 pt-2">
                        <button
                            @click="isOpen = false"
                            @keydown.escape.window="isOpen = false"
                            class="text-3xl leading-none hover:text-gray-300">&times;
                        </button>
                    </div>
                    <div class="modal-body px-8 py-8">
                        <img :src="image" alt="poster">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection