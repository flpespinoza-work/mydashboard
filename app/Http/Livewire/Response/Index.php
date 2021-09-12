<?php

namespace App\Http\Livewire\Response;

use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //public Response $response;
    public $response;
    public $search;
    public $showModal = false;

    protected $rules = [
        'response.response' => 'required|min:10'
    ];

    public function mount()
    {
        $this->response = $this->initializeResponse();
    }

    public function create()
    {
        if($this->response->getKey())
            $this->response = $this->initializeResponse();
        $this->showModal = true;
    }

    public function edit(Response $response)
    {
        if($this->response->isNot($response))
            $this->response = $response;
        $this->showModal = true;
    }

    public function initializeResponse()
    {
        return Response::make();;
    }

    public function render()
    {
        $responses = Response::where('response', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.response.index', compact('responses'));
    }

    public function saveResponse()
    {
        $this->validate();
        $this->response->save();
        $this->showModal = false;
    }

    public function deleteResponse(Response $response)
    {
        $response->delete();
    }

}
