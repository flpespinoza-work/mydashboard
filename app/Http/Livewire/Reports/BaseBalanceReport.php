<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Balance;
use Livewire\Component;

class BaseBalanceReport extends Component
{
    use Balance;

    public $result = null;
}
