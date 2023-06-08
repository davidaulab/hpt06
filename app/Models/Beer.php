<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFactory;
    //protected $guarded = ['id'];
    protected $fillable = ['name', 'description', 'vol', 'img'];

    public function breweries () {
        return $this->belongsToMany(Brewery::class, 'beer_brewery');
    }
}
