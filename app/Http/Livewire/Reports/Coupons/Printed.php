<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Models\Store;

class Printed extends Component
{
    public $result = null;

    public $filters = [
        'store' => null,
        'initial_date' => null,
        'final_date' => null
    ];

    public function render()
    {
        $stores = Store::orderBy('name')->pluck('name', 'id');
        return view('livewire.reports.coupons.printed', compact('stores'));
    }

    public function generateReport()
    {
        dd($this->filters);
    }
}
