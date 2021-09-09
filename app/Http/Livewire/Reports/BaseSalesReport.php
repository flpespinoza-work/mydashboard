<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Sales;
use Livewire\Component;

class BaseSalesReport extends Component
{
   use Sales;
   public $result = null;
}
