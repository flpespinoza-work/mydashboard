<?php

namespace App\Http\Livewire\Notification;

use App\Traits\Notifications\Campaigns;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Stats extends Component
{
    use Campaigns;

    public $campaign;

    public function mount($campaign)
    {
        $this->campaign = Crypt::decrypt($campaign);
    }

    public function render()
    {
        $data = $this->getCampaignStats($this->campaign);
        //dd($data);

        $mainColumnchart = (new ColumnChartModel())
        ->setTitle('Notificaciones')
        ->setDataLabelsEnabled(false)
        ->addColumn('Exitosas', $data->CAMP_EXITOSAS, '#09D17F')
        ->addColumn('Fallidas', $data->CAMP_FALLIDAS, '#F5927E')
        ->withoutLegend();

        $deviceColumnchart = (new ColumnChartModel())
        ->setTitle('Dispositivos')
        ->setDataLabelsEnabled(false)
        ->addColumn('Android', $data->CAMP_ANDROID, '#09D17F')
        ->addColumn('iOS', $data->CAMP_IOS, '#2394F1')
        ->withoutLegend();

        $actionsColumnchart = (new ColumnChartModel())
        ->setTitle('Acciones')
        ->setDataLabelsEnabled(false)
        ->addColumn('Leídas', $data->LEIDAS, '#2394F1')
        ->addColumn('No leídas', $data->NO_LEIDAS, '#F39449')
        ->addColumn('Eliminadas', $data->ELIMINADAS, '#F5927E')
        ->withoutLegend();

        return view('livewire.notification.stats')->with(['data' => $data, 'mainColumnchart' => $mainColumnchart, 'deviceColumnchart' => $deviceColumnchart, 'actionsColumnChart' => $actionsColumnchart]);
    }
}
