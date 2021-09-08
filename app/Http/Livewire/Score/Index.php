<?php

namespace App\Http\Livewire\Score;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['getScore'];

    public function render()
    {
        return view('livewire.score.index');
    }

    public function getScore($filters)
    {

    }
}
