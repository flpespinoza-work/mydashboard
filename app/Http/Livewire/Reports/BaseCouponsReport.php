<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class BaseCouponsReport extends Component
{
    use Coupons;

    public $result = null;
}
