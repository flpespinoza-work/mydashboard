<?php

namespace App\Http\Livewire\Reports;

use App\Traits\Reports\Users;
use Livewire\Component;

class BaseUsersReport extends Component
{
    use Users;
    public $result = null;
}
