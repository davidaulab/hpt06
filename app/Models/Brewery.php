<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brewery extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'description',
        'long',
        'lat',
    ];

    //protected $guarded = ['id'];

    public function user (){
        return $this->belongsTo(User::class);
    }

    public function beers () {
        return $this->belongsToMany(Beer::class, 'beer_brewery');
    }
}
