<?php

namespace App\Http\Livewire\Notification;

use App\Traits\Notifications\Campaigns;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, Campaigns;

    public $selectedStore = null;
    public $showStores = false;
    public $filters = [];
    public $file;

    public function render()
    {
        $stores = fnGetMyStores();
        if(strlen($this->selectedStore) >= 3)
        {
            $search = $this->selectedStore;
            $stores = array_filter($stores, function($store) use($search) {
                return (stripos($store, $search) !== false);
            }, ARRAY_FILTER_USE_BOTH);
        }

        return view('livewire.notification.create', compact('stores'));
    }

    public function selectStore($store, $name)
    {
        $this->selectedStore = $name;
        $this->filters['store'] = $store;
        $this->showStores = false;
    }

    public function clearStore()
    {
        $this->selectedStore = null;
        $this->showStores = true;
        $this->filters['store'] = null;
    }

    public function setBodyCampaign($text)
    {
        $this->filters['body'] = $text;
    }

    public function saveCampaign()
    {
        $this->validate([
            'file' => 'mimes:jpg,png|max:1024'
        ]);

        try
        {
            //Subir la imagen
            //$this->file->storeAs('push', $this->file->getClientOriginalName() , 'token-ftp');

            //Guardar campaña y notificacion
            if($this->filters['type'] == 'INFORMATIVA')
            {
                if($this->file == null)
                {
                    $this->filters['action'] = "{\"URL\":\"https://www.tokencash.mx\", \"IMG\":\"https://tokencash.mx/push/warning.jpg\", \"CUPON\":\"\"}";
                }
                else
                {

                    $this->filters['action'] = "{\"URL\":\"https://www.tokencash.mx\", \"IMG\":\"\https://tokencash.mx/push/". $this->file->getClientOriginalName() ."\", \"CUPON\":\"\"}";
                }
            }
            else
            {
                $this->filters['action'] = "{\"URL\":\"https://www.tokencash.mx\", \"IMG\":\"\", \"CUPON\":\" $this->filters['coupon'] \"}";
            }

            $this->filters['date'] = date('Y-m-d H:i:s');
            $this->filters['release'] = date('Y-m-d H:i:s', strtotime('+2 minutes'));
            $this->filters['author'] = auth()->user()->email;
            $this->filters['node'] = fnGetTokencashNode($this->filters['store']);
            $this->filters['giftcard'] = fnGetGiftcardFull($this->filters['store']);

            $created =$this->insertCampaign($this->filters);
            dd($created);

            //Lanzar evento para enviar notificación de prueba

        }
        catch (\Throwable $th)
        {
            dd($th);
        }

    }
}
