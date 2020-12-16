<?php

namespace App\View\Components;

use App\Models\Count;
use Carbon\Carbon;
use Illuminate\View\Component;

class YearlyGraph extends Component
{
    public $year;
    public $start;
    public $end;
    public $background = [];

    public function __construct($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $this->year = $year;
        $this->start = Carbon::parse($year . '-01-01')->dayOfWeek;
        $this->end = Carbon::parse($year . '-12-31')->dayOfYear;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $this->getBackground();
        return view('components.yearly-graph');
    }

    private function getBackground()
    {
        $entries = Count::whereBetween('when',[
            Carbon::parse($this->year . '-01-01')->toDateString(),
            Carbon::parse($this->year . '-12-31')->toDateString()
        ])->get();

        $counts = $entries->countBy(function($count) {
            $date = Carbon::parse($count->when);
            return $date->toDateString();
        });

        $max = $counts->max();

        $background = [];
        $start = Carbon::parse($this->year . '-01-01');
        $end = Carbon::parse($this->year . '-12-31');
        for($date = $start; $date->lte($end); $date->addDay()) {
            $i = $date->dayOfYear();
            $count = $entries->filter(function($item) use ($date) {
                $when = Carbon::parse($item->when)->startOfDay();
                $date->startOfDay();

                return $when->equalTo($date);
            })->count();

            if ($count == 0) {
                $background[$i] = 'none';
            } else if ($count === $max) {
                $background[$i] = 'most';
            } else if ($count <= $max * .2) {
                $background[$i] = 'some';
            } else if ($count <= $max * .5) {
                $background[$i] = 'average';
            } else if ($count <= $max * .8) {
                $background[$i] = 'more';
            } else {
                $background[$i] = 'none';
            }
        }

        $this->background = $background;
    }
}
