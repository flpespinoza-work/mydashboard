<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\LastPrintedCouponExport;
use App\Traits\Reports\Coupons;
use Livewire\Component;

class LastPrinted extends Component
{
    use Coupons;
    public $result = null;

    public function render()
    {
        $this->result = $this->getLastPrintedCoupon();
        return view('livewire.reports.coupons.last-printed');
    }

    public function exportReport()
    {
        return (new LastPrintedCouponExport(collect($this->coupons['REGISTROS'])))->download('reporte_ultimo_cupon_impreso.xlsx');
    }
}
