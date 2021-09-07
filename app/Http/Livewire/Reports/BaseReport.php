<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class BaseReport extends Component
{
    use Coupons;
    public $result = null;
}
