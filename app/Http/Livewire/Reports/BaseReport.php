<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class BaseReport extends Component
{
    use Coupons;

    public $filters = [
        'store' => null,
        'initial_date' => null,
        'final_date' => null
    ];

    public $result = null;
}
