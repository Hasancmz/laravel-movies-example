<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];
        $searchMovie = [];
        $searchTv = [];

        if (strlen($this->search) >= 2) {
            $searchMovie = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/movie?query=' . $this->search)
                ->json()['results'];
            $searchTv = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/tv?query=' . $this->search)
                ->json()['results'];
        }

        $searchResults = array_merge($searchMovie, $searchTv);
        $searchResults = collect($searchResults)->sortByDesc('popularity')->take(7);

        //Film ve dizi sorgusunu aynı anda yapmak için yaptık bu işlemi search kısmında birazcık yavaşlama oldu

        //dump($searchResults);

        return view('livewire.search-dropdown', [
            'searchResults' => $searchResults,
        ]);
    }
}
