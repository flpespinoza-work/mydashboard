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
                ->setDataLabelsEnabled(false)
                ->addColumn('Califico', $this->scores['totalScores'], '#53ADF4')
                ->addColumn('Comentarios', $this->scores['totalComments'], '#F17061');

            return view('livewire.score.index')->with(['columnChartModelScore' => $columnChartModelScore, 'columnChartModel' => $columnChartModel]);
        }

        return view('livewire.score.index');
    }

    public function getScore($filters)
    {
        $this->scores = null;
        $this->store_name = "Establecimiento: " . fnGetStoreNAme($filters['store']);
        $this->scores = $this->getScores($filters);
    }
}
