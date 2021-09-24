<?php

namespace App\Http\Livewire\Notification;

use App\Traits\Notifications\Campaigns;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use Campaigns;
    use WithPagination;

    protected $queryString = ['search'];
    public $reportName = 'notification.index';
    protected $listeners = ['generateReport'];
    public $store = null;
    public $search = '';

    public function render()
    {
        if(is_null($this->store))
            $stores = fnGetMyStoresNodes();
        else
            $stores = fnGetTokencashNode($this->store);

        $campaigns = $this->getCampaigns($stores, $this->search)->Paginate(10);
        //dd($campaigns);
        //$this->getCampaignStats(496);
        return view('livewire.notification.index', compact('stores', 'campaigns'));
    }
}
