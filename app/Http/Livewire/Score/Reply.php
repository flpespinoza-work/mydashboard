<?php

namespace App\Http\Livewire\Score;

use App\Models\Response;
use Livewire\Component;

class Reply extends Component
{
    protected $user;
    public $reply;
    public $selectedResponse;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $responses = Response::all(['response']);
        return view('livewire.score.reply', compact('responses'));
    }

    public function sendReply()
    {
        $this->validate();
        dd($this->user);
    }
}
