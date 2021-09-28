<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Offline extends Component
{
    public function render()
    {
        return <<<'blade'
            <div class="w-full py-2 font-bold text-center text-yellow-900 bg-yellow-100" wire:offline>
                No tienes conexión a internet
            </div>
        blade;
    }
}
