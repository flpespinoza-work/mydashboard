<?php

namespace App\Http\Livewire\Dashboard;

use App\Traits\Dashboard\Data;
use Livewire\Component;

class Index extends Component
{
    use Data;

    public $reportName = 'dashboard.index';
    public $result = [
        'balance' => '0',
        'printed_coupons' => ['coupons' => 0, 'amount' => 0],
        'redeemed_coupons' => ['redeems' => 0, 'amount' => 0]
    ];

    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.dashboard.index');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getData($filters);
       //$this->emitTo('dashboard.balance', 'showData', $filters);
    }
}
