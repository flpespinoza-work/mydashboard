<?php

namespace App\Http\Livewire\Dashboard;

use App\Traits\Dashboard\Data;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Index extends Component
{
    use Data;

    public $reportName = 'dashboard.index';
    public $result = [
        'balance' => '0',
        'printed_coupons' => ['coupons' => 0, 'amount' => 0],
        'redeemed_coupons' => ['redeems' => 0, 'amount' => 0],
        'sales' => ['sales' => 0, 'amount' => 0],
        'users' => ['totals' => 0]
    ];
    public $store_name;

    protected $listeners = ['generateReport'];

    public function mount()
    {
        $stores = fnGetMyStores();
        $store = array_key_first($stores);
        $this->store_name = $stores[$store];
        $filters = ['initial_date' => date('Y-m-d', strtotime('-7 days')), 'final_date' => date('Y-m-d'), 'store' => $store];
        $this->generateReport($filters);
    }

    public function render()
    {
        if(!is_null($this->result['users']))
        {
            $usersChartModel = null;
            $users = collect($this->result['users']);
            $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $data, $key) {
                return $usersChartModel->addColumn($key, $data, '#E86F36');
            }, (new ColumnChartModel())
                ->setTitle('Usuarios')
                ->withoutLegend()
            );

            return view('livewire.dashboard.index')->with(['usersChartModel' => $usersChartModel]);
        }

        return view('livewire.dashboard.index');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getData($filters);
        //dd($this->result);
    }
}
