<div {{ $attributes->merge(['class' => 'p-2']) }}>
    <div class="w-full border border-orange-500 p-3 rounded bg-orange-100 bg-opacity-25">
        <h4>{{ $goal->goal }}</h4>
        <div class="text-sm">{{ $goal->project->project }}</div>
        <div id="goal_{{$goal->id}}"></div>
        <div class="text-sm">{{ $goal->count->sum('value') }} of {{ $goal->total }} {{ $goal->type->type }}</div>
    </div>
</div>

<script>
    new ApexCharts(document.querySelector("#goal_{{ $goal->id }}"), {
        chart: {
            height: 200,
            type: 'radialBar',
        },
        series: [ {{ number_format($goal->count->sum('value') / $goal->total * 100,0) }} ],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 15,
                    size: "70%",
                },

                dataLabels: {
                    showOn: "always",
                    name: {
                        offsetY: -10,
                        show: true,
                        color: "#111",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#111",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        fill: {
            colors: ['#ED8936']
        },
        stroke: {
            lineCap: "round",
        },
        labels: ['Progress'],
    }).render();
</script>
