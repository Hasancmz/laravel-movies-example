<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {

        abort_if($page > 500, 204); // infinite scroll için yazdık bunu.

        $popularActors = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/popular?page=' . $page)
            ->json()['results'];

        //dump($popularActors);

        $previous = $page > 1 ? ($page - 1) : null;
        $next     = $page < 500 ? ($page + 1) : null;

        return view('actors.index', [
            'popularActors' => $popularActors,
            'previous' => $previous,
            'next' => $next
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '?append_to_response=&language=tr')
            ->json();

        $socialMedia = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '/external_ids')
            ->json();

        $date = Carbon::parse($actor['birthday'])->format('M D, Y');
        // $dateYear = Carbon::parse($actor['birthday'])->format('Y');
        // $now = Carbon::parse(now())->format('Y');
        $age = Carbon::parse($actor['birthday'])->age;

        dump($socialMedia);



        return view('actors.show', [
            'actor' => $actor,
            'age' => $age,
            'date' => $date,
            'socialMedia' => $socialMedia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
