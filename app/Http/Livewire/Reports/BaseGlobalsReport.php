<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Globals;
use Livewire\Component;

class BaseGlobalsReport extends Component
{
    use Globals;

    public $result = null;
}
