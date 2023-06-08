<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use App\Models\Brewery;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\Http;


class BeerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Paginator::useBootstrap(); 
        $beers = Beer::orderByDesc('vol')->paginate(6);
     
        

        return view ('beers.index', compact ('beers'));
    }

    public function scroll (Request $request) {

        // if ($request->ajax()){
            $beers = Beer::orderByDesc('vol')->paginate(6);
            //dd ($beers);
            $sharp = '';
            foreach ($beers as $beer) {

                $content = '<p>';
                for ($i = 0; $i < 5; $i++) {
                    $content .= '<img src="' .  asset('img/icono.png') . '" style="max-height: 1em;'; 
                
                    if ($i > ($beer->vol / 2) ) {
                        $content .= '-webkit-filter: grayscale(100%);
                        filter: grayscale(100%);
                        opacity: 0.6;';
                    }
                    $content .= '">';
                }
                $content .= '</p><p>' . $beer->description . '</p>';
                
                

                $atts = [ 
                    "size" => 'S',
                    "title" => $beer->name,
                    "content" => $content,
                    "img" => (($beer->img) ?  $beer->img :   asset('img/default.jpg') ),
                    "insideButtons" => '<a href="' . route('beers.show', $beer->id) . '" class="btn btn-primary">Ver detalle</a>'
                ];

                $sharp .= view ('components.card', $atts)->render();
            }
            return $sharp;
       /* }
        else {
            dd ('La petición no se ha realizado por ajax');
        } */
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $breweries = Brewery::orderBy ('name')->get();
        return view ('beers.create', compact('breweries'));
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
        if (Auth::check()) {
            $beer = new Beer ();
            $beer->name = $request->name;
            $beer->description = $request->description;
            $beer->vol = $request->vol;

            if ($request->hasFile('image')) {

                $beer->img = Storage::url($request->file('image')->store('public/beers'));
            }   
            $beer->saveOrFail();

            $breweries = $request->input ('brewery');
            $beer->breweries ()->attach ($breweries);
        }
        return redirect ()->route ('beers.index');
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function show(Beer $beer)
    {
        //
        $endpoint = 'https://api.frankfurter.app/latest';

        $amount = $beer->price;

        $response = Http::withoutVerifying()->get($endpoint, [
                'amount' => $amount,
                'from' => 'EUR',
                'to' => 'GBP,USD,JPY,CHF'
        ]);
        $json = $response->json ();
        //dd($json);
        $rates = $json['rates'];
       // dd($beer);
       $amount = number_format($amount ,2, ",", ".");
        return view ('beers.show', compact('beer', 'amount', 'rates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function edit(Beer $beer)
    {
        //
        $breweries = Brewery::orderBy ('name')->get();
        return view ('beers.edit', compact('beer', 'breweries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beer $beer)
    {
        //
        if (Auth::check()) {
            $beer->name = $request->name;
            $beer->description = $request->description;
            $beer->vol = $request->vol;

            if ($request->hasFile('image')) {

                $beer->img = Storage::url($request->file('image')->store('public/beers'));
            }   
            $beer->saveOrFail();

            $breweries = $request->input ('brewery');
            $beer->breweries()->sync($breweries);
        }
        return redirect ()->route ('beers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beer $beer)
    {
        //
        if (Auth::check()) { 
            $beer->breweries()->detach();
            $beer->deleteOrFail();
       }
       return redirect ()->route ('beers.index');
    }
}
