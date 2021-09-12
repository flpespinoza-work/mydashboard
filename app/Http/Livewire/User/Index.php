<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    protected $queryString = [
        'perPage',
        'search' => [
            'except' => '',
        ]
    ];

    public function render()
    {
        $users = User::search($this->search)
                ->with('roles')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->Paginate($this->perPage);

        return view('livewire.user.index', compact('users'));
    }
}
