<?php

namespace App\Http\Livewire\Dashboard;

use App\Traits\Dashboard\Data;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Index extends Component
{
    use Data;

    public $reportName = 'dashboard.index';

    public $result =
    [
        'balance' => '0',
        'printed_coupons' => ['coupons' => 0, 'amount' => 0],
        'redeemed_coupons' => ['redeems' => 0, 'amount' => 0],
        'sales' => ['sales' => 0, 'amount' => 0],
        'users' => ['totals' => 0]
    ];

    public $store_name = null;
    public $period = '';

    protected $listeners = ['generateReport'];

    public function mount()
    {
        $stores = fnGetMyStores();
        //dd($stores);
        if(count($stores))
        {
            $store = array_key_first($stores);
            $this->store_name = $stores[$store];
            $filters = ['initial_date' => date('Y-m-d', strtotime('-7 days')), 'final_date' => date('Y-m-d'), 'store' => $store];
            $this->generateReport($filters);
        }
    }

    public function render()
    {
        if(!is_null($this->result['users']))
        {
            $usersChartModel = null;
            $users = collect($this->result['users']);
            $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $data, $key) {
                $day = __(date('D', strtotime(str_replace('/', '-', $key))));
                $date = date('d/m/Y', strtotime($key));
                return $usersChartModel->addColumn($day . ' - ' . $date, $data, '#E86F36');
            }, (new ColumnChartModel())
                ->setTitle('Usuarios')
                ->setAnimated(true)
                ->withoutLegend()
                ->withGrid()
            );

            return view('livewire.dashboard.index')->with(['usersChartModel' => $usersChartModel]);
        }

        return view('livewire.dashboard.index');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreName($filters['store']);
        $this->period = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getData($filters);
    }
}
