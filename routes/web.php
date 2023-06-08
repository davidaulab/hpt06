<?php

use App\Http\Controllers\BeerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BreweryController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/bienvenido', function () {
    return view('welcome');
})->name ('welcomepage');

Route::get('/', function () {
    return view('hello', ['nombre' => 'David', 'apellidos' => 'Martinez']);
})->name('home');




Route::resource('/beers', BeerController::class)->parameters(["beers"]);

Route::group(['middleware' => 'auth'], function () {

    Route::delete('/brewery/destroy/{brewery}', [BreweryController::class, 'destroy'])->name('brewery.destroy');

    Route::get('/brewery/edit/{brewery}', [BreweryController::class, 'edit'])->name('brewery.edit');
    Route::put('/brewery/update/{brewery}', [BreweryController::class, 'update'])->name('brewery.update');
    
    
    Route::get('/brewery/create', [BreweryController::class, 'create'])->name('brewery.create');
    Route::post('/brewery/store', [BreweryController::class, 'store'])->name('brewery.store');


    Route::get('/brewery/user/{user}', [BreweryController::class, 'user'])->name('brewery.user');

} );



Route::get('/brewery/{brewery}', [BreweryController::class, 'show'])->name('brewery');

Route::get('/breweries', [BreweryController::class, 'index'])->name ('breweries');
Route::post('/breweries', [BreweryController::class, 'index']);

Route::get('/cerveceria/{name}', [BreweryController::class, 'friendly'])->name('cerveceria');


Route::get('/contact', function () {
    return view ('contact');
})->name('contact');

Route::post('/contactsent', [ContactController::class, 'sendMail'])->name('contact.sent');

Route::get ('/aboutus', function () {
    return view ('aboutus');
})->name('aboutus');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get ('/beer/scroll', [BeerController::class, 'scroll'] )->name ('beer.scroll');


Route::get ('/contador', function () {
    $counter = session('counter', 0);
    return view ('contador', compact('counter'));
});

Route::post ('/contador', function () {
    $counter = session('counter', 0);
    $counter++;
    session(['counter' => $counter]);
    return view ('contador', compact('counter'));
});
