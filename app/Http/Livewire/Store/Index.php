<?php

namespace App\Http\Livewire\Store;

use App\Imports\StoreImport;
use App\Models\Store;
use App\Models\Group;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $groups;
    public $store, $group, $file;
    public $search = '';
    public $showModal = false;

    protected $queryString = [
        'search' => [
            'except' => '',
        ]
    ];

    protected $rules = [
        'store.name' => 'required',
        'store.node' => 'required|unique:stores,node',
        'store.giftcard' => 'required|unique:stores,giftcard',
        'store.budget' => 'required|unique:stores,budget',
        'store.email' => 'email:rfc',
        'store.phone' => 'digits:10'
    ];

    public function mount()
    {
        $this->store = $this->initializeStore();
        $this->groups = Group::orderBy('name')->get();
    }

    public function render()
    {
        $stores = Store::search($this->search)
        ->with('group')
        ->orderBy('name')
        ->Paginate(10);
        return view('livewire.store.index', compact('stores'));
    }

    public function create()
    {
        if($this->store->getKey())
            $this->store = $this->initializeStore();
        $this->showModal = true;
    }

    public function initializeStore()
    {
        return Store::make();
    }

    public function saveStore()
    {
        $this->validate();

        //Asignar grupo
        $this->store->group_id = $this->group;
        $this->store->save();
        $this->showModal = false;
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
    }

    public function importStores()
    {
        try
        {

            $this->validate([
                'file' => 'file|mimes:xlsx,xls'
            ]);

            Excel::import(new StoreImport, $this->file);

            $this->alertSuccess();
        }
        catch (\Throwable $th)
        {
            $this->alertError();
        }
    }

    public function alertSuccess()
    {
        $this->dispatchBrowserEvent('swal:success', [
            'type' => 'success',
            'message' => 'Se importaron los registros correctamente'
        ]);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('swal:error', [
            'type' => 'error',
            'message' => 'Error al importar los registros'
        ]);
    }
}
