<?php

namespace App\Imports;

use App\Models\Store;
use App\Models\Group;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $grupo = Group::where('name', $row['grupo'] )->first()->id;

        //Crear un nuevo establecimiento
        return new Store([
            'group_id' => $grupo,
            'name' => $row['establecimiento'],
            'node' => $row['nodo'],
            'giftcard' => $row['giftcard'],
            'budget' => $row['presupuesto']
        ]);
    }

}
