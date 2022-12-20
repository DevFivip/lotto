@extends('layouts.app')



@section('scripts')

<link href="js/apexchart/dist/style.css" rel="stylesheet" />

<!-- <style>
    #chart {
        max-width: 650px;
        margin: 35px auto;
    }
</style> -->

<script>
    window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        );
    window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        );
    window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        );
</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
    // Based on https://gist.github.com/blixt/f17b47c62508be59987b
    var _seed = 42;
    Math.random = function() {
        _seed = (_seed * 16807) % 2147483647;
        return (_seed - 1) / 2147483646;
    };
</script>
@endsection

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Jugadas</div>
                <div class="card-body">

                    <div id="chart"></div>

                    <h3 class="mt-3">Grafica detallada por hora</h3>
                    <div class="col mt-3">
                        @foreach($schedule as $s)
                        <a class='btn btn-primary' href="/chart/detail?loteria_id={{$loteria_id}}&created_at={{$created_at}}&schedule={{$s}}">{{$s}}</a>
                        @endforeach
                    </div>
                    <script>
                        let jugadas = @json($jugadas);
                        let monto_total = @json($monto_total);
                        let premio_total = @json($premio_total);
                        let schedule = @json($schedule);
                        let max_riesgo = @json($max_riesgo);
                        let min_riesgo = @json($min_riesgo);
                        let loteria_name = "{{$loteria_name}}";

                        var options = {
                            series: [{
                                    name: "Jugadas",
                                    data: jugadas,
                                },
                                {
                                    name: "Ventas (BS)",
                                    data: monto_total,
                                },
                                {
                                    name: "Ganadores",
                                    data: premio_total,
                                },
                                {
                                    name: "MAX RIESGO",
                                    data: max_riesgo,
                                },
                                {
                                    name: "MIN RIESGO",
                                    data: min_riesgo,
                                },
                            ],
                            chart: {
                                height: 400,
                                type: "area",
                                zoom: {
                                    enabled: true,
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                width: [5, 7, 5, 6, 3],
                                curve: "smooth",
                                dashArray: [0, 8, 5, 0, 0],
                            },
                            title: {
                                text: loteria_name,
                                align: "left",
                            },
                            legend: {
                                tooltipHoverFormatter: function(val, opts) {
                                    return (
                                        val +
                                        " - <strong>" +
                                        opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
                                        "</strong>"
                                    );
                                },
                            },
                            markers: {
                                size: 2,
                                hover: {
                                    sizeOffset: 5,
                                },
                            },
                            xaxis: {
                                categories: schedule,
                            },
                            tooltip: {
                                y: [{
                                        title: {
                                            formatter: function(val) {
                                                return val;
                                            },
                                        },
                                    },
                                    {
                                        title: {
                                            formatter: function(val) {
                                                return val;
                                            },
                                        },
                                    },
                                    {
                                        title: {
                                            formatter: function(val) {
                                                return val;
                                            },
                                        },
                                    },
                                ],
                            },
                            grid: {
                                borderColor: "#f1f1f1",
                            },
                        };

                        var chart = new ApexCharts(document.querySelector("#chart"), options);
                        chart.render();
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection