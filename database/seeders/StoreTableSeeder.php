<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estaciones = [
            'ATG' => [
                [
                    'name' => 'Gasomax Corona',
                    'node' => '316971',
                    'budget' => '317158',
                    'giftcard' => '4441302971'
                ],
                [
                    'name' => 'Gasomax Peñon',
                    'node' => '316963',
                    'budget' => '317150',
                    'giftcard' => '4969613043'
                ],
                [
                    'name' => 'Gasomax Ojuelos',
                    'node' => '316967',
                    'budget' => '317154',
                    'giftcard' => '4961165675'
                ],
                [
                    'name' => 'Gasomax Colubosa',
                    'node' => '316964',
                    'budget' => '317151',
                    'giftcard' => '4969613032'
                ],
                [
                    'name' => 'Gasomax Potrero',
                    'node' => '316965',
                    'budget' => '317152',
                    'giftcard' => '4286870182'
                ],
                [
                    'name' => 'Gasomax Duque',
                    'node' => '316957',
                    'budget' => '317144',
                    'giftcard' => '4971122080'
                ],
                [
                    'name' => 'Gasomax Paraiso',
                    'node' => '316960',
                    'budget' => '317147',
                    'giftcard' => '4878750286'
                ],
                [
                    'name' => 'Gasomax El Refugio',
                    'node' => '316657',
                    'budget' => '316842',
                    'giftcard' => '4871124410'
                ],
                [
                    'name' => 'Gasomax Reloj',
                    'node' => '316969',
                    'budget' => '317156',
                    'giftcard' => '4871489845'
                ]
            ],
            'Euro' => [
                [
                    'name' => 'Eurogas',
                    'node' => '312930',
                    'budget' => '313082',
                    'giftcard' => '4441658450'
                ],
                [
                    'name' => 'Gasomax Aerogas',
                    'node' => '312931',
                    'budget' => '313083',
                    'giftcard' => '4441655619'
                ],
                [
                    'name' => 'Gasomax Montelongo',
                    'node' => '311102',
                    'budget' => '311251',
                    'giftcard' => '4443716797'
                ],
                [
                    'name' => 'Gasomax Santa Maria',
                    'node' => '336747',
                    'budget' => '336933',
                    'giftcard' => '4443519960'
                ],
                [
                    'name' => 'Gasomax La Hacienda',
                    'node' => '336753',
                    'budget' => '336939',
                    'giftcard' => '4441931096'
                ],
                [
                    'name' => 'Gasomax Europits',
                    'node' => '336945',
                    'budget' => '336945',
                    'giftcard' => '4443519966'
                ],
                [
                    'name' => 'Gasomax Del Monte',
                    'node' => '336763',
                    'budget' => '336949',
                    'giftcard' => '4444274096'
                ]
            ],
            'Hormadi' => [
                [
                    'name' => 'Gasomax San Luis',
                    'node' => '312129',
                    'budget' => '312279',
                    'giftcard' => '4442579476'
                ],
                [
                    'name' => 'Gasomax Relampago',
                    'node' => '312130',
                    'budget' => '312280',
                    'giftcard' => '4442039217'
                ],
                [
                    'name' => 'Gasomax Tornado',
                    'node' => '312131',
                    'budget' => '312281',
                    'giftcard' => '4445971423'
                ],
                [
                    'name' => 'Gasomax KM 21',
                    'node' => '312132',
                    'budget' => '312282',
                    'giftcard' => '4443568140'
                ],
                [
                    'name' => 'Gasomax Bocas',
                    'node' => '312133',
                    'budget' => '312283',
                    'giftcard' => '4442203516'
                ],
                [
                    'name' => 'Gasomax Arriaga',
                    'node' => '312134',
                    'budget' => '312284',
                    'giftcard' => '4443861331'
                ],
                [
                    'name' => 'Gasomax Tornado Rio Verde',
                    'node' => '312136',
                    'budget' => '312286',
                    'giftcard' => '4271663898'
                ],
                [
                    'name' => 'Gasomax Villa de Arista',
                    'node' => '312137',
                    'budget' => '312287',
                    'giftcard' => '4441749376'
                ],
                [
                    'name' => 'Gasomax Cd.Fernandez',
                    'node' => '312138',
                    'budget' => '312288',
                    'giftcard' => '4871096107'
                ]
            ],
            'Servicio El Milagro' => [
                [
                    'name' => 'Gasomax El Milagro',
                    'node' => '312933',
                    'budget' => '313085',
                    'giftcard' => '4445859714'
                ],
            ],
            'Guerra' => [
                [
                    'name' => 'Curva',
                    'node' => '349655',
                    'budget' => '349655',
                    'giftcard' => '4448123353'
                ],
                [
                    'name' => 'Guerra',
                    'node' => '394912',
                    'budget' => '395231',
                    'giftcard' => '4448123354'
                ]
            ],
            'Petro' => [
                [
                    'name' => 'El Dorado',
                    'node' => '311744',
                    'budget' => '311893',
                    'giftcard' => '4441654475'
                ],
                [
                    'name' => 'Gasomax ExpressGas',
                    'node' => '311745',
                    'budget' => '311894',
                    'giftcard' => '4441306586'
                ],
                [
                    'name' => 'Gasomax Capulines',
                    'node' => '312308',
                    'budget' => '312458',
                    'giftcard' => '4441654481'
                ],
                [
                    'name' => 'Gasomax Central 57- 5436',
                    'node' => '312309',
                    'budget' => '312459',
                    'giftcard' => '4861000006'
                ],
                [
                    'name' => 'Gasomax El Parque',
                    'node' => '312310',
                    'budget' => '312460',
                    'giftcard' => '4192708079'
                ],
                [
                    'name' => 'Gas Juarez',
                    'node' => '312311',
                    'budget' => '312461',
                    'giftcard' => '4441654491'
                ],
                [
                    'name' => 'Gasomax Estancia - 3812',
                    'node' => '312312',
                    'budget' => '312462',
                    'giftcard' => '4881014358'
                ],
                [
                    'name' => 'Gasomax La Granja',
                    'node' => '312313',
                    'budget' => '312463',
                    'giftcard' => '4448292661'
                ],
                [
                    'name' => 'Gasomax La Posta',
                    'node' => '312314',
                    'budget' => '312464',
                    'giftcard' => '4441301302'
                ],
                [
                    'name' => 'Gasomax Globos',
                    'node' => '312315',
                    'budget' => '312465',
                    'giftcard' => '4773942162'
                ],
                [
                    'name' => 'Gasomax Mariposas San Luis',
                    'node' => '312318',
                    'budget' => '312468',
                    'giftcard' => '4442383802'
                ],
                [
                    'name' => 'Gasomax Media Luna',
                    'node' => '312322',
                    'budget' => '312472',
                    'giftcard' => '4871124050'
                ],
                [
                    'name' => 'Gasomax Purisima',
                    'node' => '312323',
                    'budget' => '312473',
                    'giftcard' => '4441301749'
                ],
                [
                    'name' => 'Gasomax Españita',
                    'node' => '312325',
                    'budget' => '312475',
                    'giftcard' => '4192708267'
                ],
                [
                    'name' => 'Gasomax Tula 2000',
                    'node' => '312326',
                    'budget' => '312476',
                    'giftcard' => '8321029299'
                ],
                [
                    'name' => 'Gasomax Gas Tula',
                    'node' => '312327',
                    'budget' => '312477',
                    'giftcard' => '8321029298'
                ]
            ],
            'ATH' => [
                [
                    'name' => 'La Paz',
                    'node' => '340771',
                    'budget' => '340771',
                    'giftcard' => '4448482448'
                ]
            ],
            'Gaxxor' => [
                [
                    'name' => 'Shell Arcos del Milenio',
                    'node' => '242624',
                    'budget' => 'supra',
                    'giftcard' => 'SUPRA'
                ],
                [
                    'name' => 'Shell Nogalera',
                    'node' => '245928',
                    'budget' => 'isspx',
                    'giftcard' => 'SNOGA'
                ],
                [
                    'name' => 'Shell Mercado del Mar',
                    'node' => '245929',
                    'budget' => 'smm',
                    'giftcard' => 'SMERCADOMAR'
                ],
                [
                    'name' => 'Shell Etzatlan',
                    'node' => '254437',
                    'budget' => 'SETZPRE',
                    'giftcard' => 'SHELLETZ'
                ],
                [
                    'name' => 'Shell Cuauhtemoc',
                    'node' => '273193',
                    'budget' => '273324',
                    'giftcard' => '3123281304'
                ]
            ]
        ];

        foreach($estaciones as $grupo => $stores)
        {
            $group = DB::table('groups')->where('name', $grupo)->first();
            foreach($stores as $store)
            {
                DB::table('stores')->insert([
                    'name' => $store['name'],
                    'node' => $store['node'],
                    'giftcard' => $store['giftcard'],
                    'budget' => $store['budget'],
                    'group_id' => $group->id
                ]);
            }
        }
    }
}
