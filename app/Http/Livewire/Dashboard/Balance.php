<?php

namespace App\Http\Livewire\Dashboard;

use App\Traits\Dashboard\Data;
use Livewire\Component;

class Balance extends Component
{
    use Data;
    public $balance;

    protected $listeners = ['showData'];

    public function render()
    {

        return view('livewire.dashboard.balance');
    }

    public function showData($filters)
    {
        $this->balance = $this->getBalance($filters);
    }
}
