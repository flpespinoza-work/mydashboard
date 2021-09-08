<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public $reportName = 'notification.index';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.notification.index');
    }
}
