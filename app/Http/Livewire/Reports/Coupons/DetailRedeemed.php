<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\DetailRedeemedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;

class DetailRedeemed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.detail-redeemed';
    public $report_data;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.coupons.detail-redeemed');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getDetailRedeemedCoupons($filters);
    }

}
