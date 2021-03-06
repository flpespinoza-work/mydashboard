<?php

namespace App\Http\Livewire\Score;

use App\Traits\Scores\Scores;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Index extends Component
{
    use Scores;

    public $scores = null;
    public $store_name;
    public $report_data;

    protected $listeners = ['getScore'];

    public function render()
    {
        if(!is_null($this->scores) && !empty($this->scores))
        {
            $columnChartModel = null;
            $columnChartModelScore = null;

            $columnChartModel = (new ColumnChartModel())
            ->setTitle('Calificaciones')
            ->setHorizontal(true)
            ->setDataLabelsEnabled(false)
            ->addColumn('', $this->scores['stars_5'], '#09D17F')
            ->addColumn('', $this->scores['stars_4'], '#A8E485')
            ->addColumn('', $this->scores['stars_3'], '#F7DA38')
            ->addColumn('', $this->scores['stars_2'], '#F7A038')
            ->addColumn('', $this->scores['stars_1'], '#F54924')
            ->withoutLegend()
            ;

            $columnChartModelScore = (new ColumnChartModel())
                ->setTitle('Calificaciones - Comentarios')
                ->setDataLabelsEnabled(true)
                ->addColumn('Califico', $this->scores['totalScores'], '#53ADF4')
                ->addColumn('Comentarios', $this->scores['totalComments'], '#F17061');

            return view('livewire.score.index')->with(['columnChartModelScore' => $columnChartModelScore, 'columnChartModel' => $columnChartModel]);
        }

        return view('livewire.score.index');
    }

    public function getScore($filters)
    {
        $this->scores = null;
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->report_data['seller'] = $filters['seller'];
        $this->scores = $this->getScores($filters);
    }
}
