<?php

namespace App\Http\Livewire\Response;

use App\Models\Response;
use Livewire\Component;

class Index extends Component
{
    public $response;

    protected $rules = [
        'response' => 'required|min:10'
    ];
    public function render()
    {
        $responses = Response::all();
        return view('livewire.response.index', compact('responses'));
    }

    public function addResponse()
    {
        $this->validate();

        Response::create([
            'response' => $this->response
        ]);

        $this->reset();
    }

    public function resetForm()
    {
        $this->reset();
    }
}
