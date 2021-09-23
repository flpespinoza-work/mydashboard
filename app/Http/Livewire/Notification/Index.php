<?php

namespace App\Http\Livewire\Notification;

use App\Traits\Notifications\Campaigns;
use Livewire\Component;

class Index extends Component
{
    use Campaigns;

    public $reportName = 'notification.index';
    protected $listeners = ['generateReport'];

    public function render()
    {
        $stores = fnGetMyStoresNodes();
        $campaigns = $this->getCampaigns($stores);
        //$this->getCampaignStats(496);
        return view('livewire.notification.index', compact('stores'));
    }
}
