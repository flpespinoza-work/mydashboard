<?php

namespace App\Http\Livewire\Score;

use Livewire\Component;
use App\Models\Store;

class Filters extends Component
{

    public $filters = [
        'store' => null,
        'initial_date' => null,
        'final_date' => null,
        'seller' => null
    ];

    public $sellers = [];

    protected $rules = [
        'filters.store' => 'required',
        'filters.initial_date' => 'required',
        'filters.final_date' => 'required',
        'filters.seller' => 'required'
    ];


    public function mount()
    {
        $this->filters['initial_date'] = date('Y-m-d');
        $this->filters['final_date'] = date('Y-m-d');
    }

    public function render()
    {
        $stores = Store::orderBy('name')->pluck('name', 'id');
        return view('livewire.score.filters', compact('stores'));
    }

    public function updateSellers()
    {
        $this->sellers = fnGetSellers($this->filters['store']);
        //dd($this->sellers);
    }

    public function sendFiltersToScore()
    {

    }
}
