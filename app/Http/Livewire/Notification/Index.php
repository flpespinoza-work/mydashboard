<?php

namespace App\Http\Livewire\Notification;

use App\Models\Campaign;
use App\Traits\Notifications\Campaigns;
use Illuminate\Support\Facades\Crypt;
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

    public $showModal = false;
    public $program = [];

    public function render()
    {
        if(is_null($this->store))
            $stores = fnGetMyStoresNodes();
        else
            $stores = fnGetTokencashNode($this->store);

        $campaigns = $this->getCampaigns($stores, $this->search)->Paginate(10);
        return view('livewire.notification.index', compact('stores', 'campaigns'));
    }

    public function stats($campaign, $status)
    {
        switch($status)
        {
            case '1':
                return redirect()->to(route('notifications.stats', ['campaign' => $campaign]));
            case '2':
                $this->dispatchBrowserEvent('swal:warning', [
                    'type' => 'error',
                    'message' => 'La campaña se encuentra en procesamiento'
                ]);
                break;
            default:
                $this->dispatchBrowserEvent('swal:error', [
                    'type' => 'error',
                    'message' => 'La campaña se encuentra suspendida'
                ]);
                break;
        }
    }

    public function showProgram($campaign)
    {
        $this->program['campaign'] = $campaign;
        $this->showModal = true;
    }

    public function program()
    {
        $this->showModal = false;
        $this->program['campaign'] = Crypt::decrypt($this->program['campaign']);
        if($this->programCampaign($this->program))
        {
            $this->dispatchBrowserEvent('swal:success', [
                'type' => 'success',
                'message' => 'La campaña se programo correctamente'
            ]);
        }
        else
        {
            $this->dispatchBrowserEvent('swal:error', [
                'type' => 'error',
                'message' => 'Hubo error al programar la campaña, intentelo de nuevo.'
            ]);
        }
    }
}
