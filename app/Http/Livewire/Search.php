<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Brewery;

class Search extends Component
{
    public $searchTerm = '';
    public $searchedTerm ='';

    public $breweries = null;

    public function render()
    {
        $this->searchedTerm = '%' . $this->searchTerm .'%';
        $this->breweries = Brewery::where('name', 'like', $this->searchedTerm)->orderBy('name')->get();

        return view('livewire.search');
    }
}
