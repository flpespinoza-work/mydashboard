<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public $reportName = 'dashboard.index';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
