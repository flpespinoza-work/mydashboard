<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Group;

class Index extends Component
{
    public function render()
    {
        $groups = Group::with('stores')->get();
        return view('livewire.group.index', compact('groups'));
    }
}
