<?php

namespace App\Http\Livewire\Dashboard;

use App\Traits\Dashboard\Data;
use Livewire\Component;

class Balance extends Component
{
    use Data;

    public $balance;
    public $filters;

    protected $listeners = ['showData'];

    public function render()
    {
        //$this->balance = $this->getBalance($this->filters);
        return view('livewire.dashboard.balance');
    }

    public function showData($filters)
    {
        dd($filters);
    }

}
