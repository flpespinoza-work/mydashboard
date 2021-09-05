<?php

namespace App\Http\Livewire\Response;

use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $response;
    public $search;

    protected $rules = [
        'response' => 'required|min:10'
    ];
    public function render()
    {
        $responses = Response::where('response', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'desc')
        ->paginate(10);

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

    public function deleteResponse(Response $response)
    {
        $response->delete();
    }

    public function resetForm()
    {
        $this->reset();
    }
}
