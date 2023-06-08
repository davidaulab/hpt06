<?php

namespace Database\Seeders;

use App\Models\Beer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('beers')->insert([ 'name' => 'Aguila Dorada', 'description' => 'Cerveza tostada ligera', 'vol' => 3.5 ]);
        DB::table('beers')->insert([ 'name' => 'Valhalla', 'description' => 'Hidromiel con sabor cerveza', 'vol' => 5]);
        DB::table('beers')->insert([ 'name' => 'Alhambra', 'description' => 'Cerveza de Granada amarga', 'vol' => 9]);
        DB::table('beers')->insert([ 'name' => 'Aguila tostada', 'description' => 'Cerveza tostada ligera', 'vol' => 3.5 ]);
        DB::table('beers')->insert([ 'name' => 'Valhalla especial', 'description' => 'Hidromiel con sabor cerveza', 'vol' => 5]);
        DB::table('beers')->insert([ 'name' => 'Alhambra reserva', 'description' => 'Cerveza de Granada amarga', 'vol' => 9]);

        $beer = new Beer ();
        $beer->fill(['name' => 'Estrella del Sur', 'description' => 'Cerveza suave de Murcia', 'vol' => 2]);
        $beer->saveOrFail();


    }
}
