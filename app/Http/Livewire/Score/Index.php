<?php

namespace App\Http\Livewire\Score;

use App\Traits\Scores\Scores;
use Livewire\Component;

class Index extends Component
{
    use Scores;
    protected $listeners = ['getScore'];

    public function render()
    {
        return view('livewire.score.index');
    }

    public function getScore($filters)
    {

    }
}
