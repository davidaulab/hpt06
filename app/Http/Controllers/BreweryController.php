<?php

namespace App\Http\Controllers;

use App\Http\Requests\BreweryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Beer;
use App\Models\Brewery;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class BreweryController extends Controller
{
    //
    public function index () {
        Paginator::useBootstrap(); 

        $breweries = Brewery::orderBy('name') -> paginate(6);

        return view ('breweries.index', compact ('breweries'));
    }
    public function indexQB () {
        /* 
        $breweries = [
            [1, 'Canguro rojo', 'Selección de Emilio', 39.1454172,-0.4299322],
            [3, 'Yunque', 'Selección de David', 42.5569502,-6.61183],
            [7, 'Cuatro latas', 'Selección de Douglas', 38.3436389,-0.4868893],
            [9, 'El duende', 'Selección de Belén', 39.3930718,-3.2213942],
            [11, 'La sureña', 'Selección de Carlos', 40.4237533,-3.6753228],
            [13, 'Luwak', 'Cervezas y Tés', 40.4237533,-3.6753228]
            
        ];*/

        $breweries = DB::table('breweries')->get();

         // dd($breweries);
       
        return view ('breweries.index', compact ('breweries'));
    }

    public function friendly ($name) {
        $breweries = Brewery::where ('name', 'like', '%' . $name . '%')->get ();

        if (isset ($breweries)) {

            if (count ($breweries) == 1) {
                $brewery = $breweries->first ();
                //$user = User::findOrFail ($brewery->creator);
                 //return redirect()->route ('brewery', $brewery);
                return view ('breweries.show', compact('brewery'));
            }
            else { // hay dos o más
                $msg = 'Hay mas de una cervecería con el nombre indicado';
                return view ('breweries.index', compact ('breweries', 'msg'));
            }
            

        }
        else {
            return redirect()->route('breweries')->with('message', 'No hemos encontrado la cervecería que buscas, ¿por qué no pruebas una de éstas?')
                ->with('code', '400');
        }
       
    }

    public function user (User $user) {
        
        $breweries = Brewery::whereBelongsTo ($user)->get ();
        //$breweries = Brewery::where ('user_id',  $user->id)->get ();
       

        if (isset ($breweries)) {
            return view ('breweries.index', compact ('breweries'));
        }
        else {
            return redirect()->route('breweries')->with('message', 'Todavía no has sugerido ninguna cervecería.')
                ->with('code', '400');
        }

    }
    public function show ( Brewery $brewery){
       // $user = User::findOrFail ($brewery->user_id);
       // dd($brewery);

        $endpoint = 'https://api.chucknorris.io/jokes/random';

        $response = Http::withoutVerifying()->get($endpoint);
        $responseJson = $response->json();
        $quote = $responseJson['value'];

        return view ('breweries.show', compact('brewery', 'quote'));
    }

    public function showQB ( $id){
       /* $brewery = '';
        $breweries = [
            [1, 'Canguro rojo', 'Selección de Emilio', 39.1454172,-0.4299322],
            [3, 'Yunque', 'Selección de David', 42.5569502,-6.61183],
            [7, 'Cuatro latas', 'Selección de Douglas', 38.3436389,-0.4868893],
            [9, 'El duende', 'Selección de Belén', 39.3930718,-3.2213942],
            [11, 'La sureña', 'Selección de Carlos', 40.4237533,-3.6753228]
            
        ];
    
        foreach ($breweries as $auxbrewery) {
            if ($auxbrewery[0] == $id) {
                $brewery = $auxbrewery;
            }
        }
       */

        $brewery = DB::table('breweries')->find($id); 

        //dd($brewery);
        if ($brewery == null) {
            return redirect()->route('breweries') -> with('message', "No existe la cervecería que quieres ver") -> with ('code', "ERROR");
           //  $breweries = DB::table('breweries')->get();
           //  $code = 'ERROR';
           //  $msg = 'La cervecería que buscas aún no está en nuestro portal.';
          //   return view ('breweries', ['breweries' => $breweries, 'code' => $code, 'msg' => $msg]);

          // return view ('breweries', compact ('breweries', 'code' , 'msg'));
        }
        return view ('breweries.show', compact('brewery'));

    }
    public function create () {
        $beers = Beer::orderBy('name')->get();
        return view ('breweries.create', compact ('beers'));
    }

    public function store (BreweryRequest $request) {
       // dd($request);
        
       
       //dd ($beers);
       $brewery = new Brewery ();

        $brewery->user_id = Auth::id();
        
        $brewery->fill($request->validated());
        if ($request->hasFile('image')) {
            $brewery['image'] = Storage::url($request->file('image')->store('public/breweries'));
        }
        

        
        $brewery->saveOrFail();
        
        $beers = $request->get ('beer');
        $brewery->beers()->attach($beers);
               
        return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha creado correctamente']);
   
    }
    public function storeQB (BreweryRequest $request) {
        //dd ($request);

        DB::table('breweries')->insert([
            'name'          => $request->input ('name'),
            'description'   => $request->input ('description'),
            'lat'           => $request->input ('latitud'),
            'long'          => $request->input ('longitud'),
        ]);

        return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha creado correctamente']);

    }

    public function edit (Brewery $brewery) {
                       
        if (((Auth::check()) && 
                    (
                        (Auth::user()->id == $brewery->user_id ) || 
                        (Auth::user()->level <= 10) 
                    ))) {
            $beers = Beer::orderBy('name')->get();
            return view ('breweries.edit', compact('brewery', 'beers'));
        }
        else {
            return redirect()->route('login');
        }
        
    }

    public function editQB ($id) {

        $brewery = DB::table('breweries')->find($id); 

        //dd($brewery);
        if ($brewery == null) {
            return redirect()->route('breweries') -> with('message', "No existe la cervecería que quieres ver") -> with ('code', "ERROR");
        }
        return view ('breweries.edit', compact('brewery'));

    }
    public function update (BreweryRequest $request, Brewery $brewery) {
        if (((Auth::check()) && 
        (
            (Auth::user()->id == $brewery->user_id) || 
            (Auth::user()->level <= 10) 
        ))) {
            if ($request->hasFile('image')) {
                $brewery['image'] = Storage::url($request->file('image')->store('public/breweries') );    
            }
        // dd($request);
            $brewery->fill($request->validated());

            $brewery->user_id = Auth::user()->id;

            $brewery->saveOrFail();

            $beers = $request->get ('beer');
            $brewery->beers()->sync($beers);

            return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha modificado correctamente']);
        }
        else {
            return redirect()->route('login');
        }
    }
    public function updateQB (BreweryRequest $request, $id) {
        //dd ($request);

        DB::table('breweries')->where('id', $id) ->update([
            'name'          => $request->input ('name'),
            'description'   => $request->input ('description'),
            'lat'           => $request->input ('latitud'),
            'long'          => $request->input ('longitud'),
        ]);

        return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha modificado correctamente']);

    }
    public function destroy (Brewery $brewery) {
        if (((Auth::check()) && 
        (
            (Auth::user()->id == $brewery->user_id) || 
            (Auth::user()->level <= 10) 
        ))) {
            $brewery->beers()->detach();
            $brewery->deleteOrFail();
            return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha eliminado correctamente']);
        }
        else {
            return redirect()->route('login');
        }        
    }
    public function destroyQB ($id) {
       
        DB::table('breweries')->delete($id);
        return redirect()->route ('breweries')->with (['code' => 'OK', 'message' => 'La cervecería se ha eliminado correctamente']);

    }
}
