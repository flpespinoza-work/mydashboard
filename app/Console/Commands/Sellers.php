<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Seller;

class Sellers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sellers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener vendedores de cada establecimiento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Iniciar conexion con reportes
        $tokDB = DB::connection('reportes');

        DB::table('sellers')->truncate();

        //Recorrer los establecimientos
        foreach(Store::all(['node', 'id']) as $store)
        {
            //Buscar vendedores por establecimiento en la tabla de dat_comentarios de tokencash
            $sellers = $store->sellers()->pluck('name')->toArray();
            $day = date('Y-m-d 00:00:00', strtotime('-6 months'));
            $tokSellers = $tokDB->table('dat_comentarios')
            ->selectRaw('DISTINCT COM_VENDEDOR')
            ->where('COM_FECHA_HORA', '>', $day)
            ->where('COM_ESTABLECIMIENTO_ID', $store->node)
            ->whereNotIn('COM_VENDEDOR', $sellers)
            ->where('COM_VENDEDOR', '!=', '')
            ->orderBy('COM_VENDEDOR')
            ->get();

            if(count($tokSellers))
            {
                //Guardar vendedores en tabla sellers
                foreach($tokSellers as $seller)
                {
                    $name = utf8_encode($seller->COM_VENDEDOR);
                    //$name = $seller->COM_VENDEDOR;
                    Seller::create(['store_id' => $store->id, 'name' => $name]);
                }
            }
        }
    }
}
