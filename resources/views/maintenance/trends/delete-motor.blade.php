@include('utility.prefix')

<div class="py-4" style="min-width: 350px;">

    <!-- <a href="/report/{{ $table . '/' . $equipment}}">
        <button class="mb-3" type="button" class="btn btn-primary">
            Download
        </button>
    </a> -->

    {{-- TEMPERATURE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Temperature of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="temperature"></canvas>
        </div>
    </div>

    @include('utility.image-temperature')

    {{-- VIBRATION DE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Vibration DE of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="vibration_de"></canvas>
        </div>
    </div>

    {{-- VIBRATION NDE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Vibration NDE of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="vibration_nde"></canvas>
        </div>
    </div>

    @include('utility.image-vibration')

    {{-- GREASING RECORDS --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Greasing record of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="number_of_greasing"></canvas>
        </div>
    </div>

    {{-- FINDINGS --}}
    @if ( (count($findings) > 0) && !is_null($findings))
    <div class="mb-3 mt-4">
        <h6 class="text-center text-secondary mb-1">Findings of {{ $equipment }}</h6>
        <div class="text-center text-secondary form-text">The top one is the newest.</div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Desc</th>
                    <th class="text-center" style="width: 50px;">Img</th>
                    <th>Rptr</th>
                    <th class="text-center" style="width: 80px;">Date</th>
                </tr>

                @foreach ($findings as $finding)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ($finding as $key => $value)

                    @switch($key)

                    @case('image')
                    @switch($value)
                    @case(!null)
                    <td class="text-center" style="width: 50px;">
                        <a href="/storage/findings/{{ $value }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="grey" class="bi bi-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12" />
                            </svg>
                        </a>
                    </td>
                    @break

                    @default
                    <td></td>
                    @endswitch

                    @break

                    @case('reporter')
                    <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $finding->$key }}">{{ explode(' ', $finding->$key)[0] }}</td>
                    @break

                    @case('created_at')
                    <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $finding->$key }}">{{ $motorService->formatDDMMYY($finding->$key) }}</td>
                    @break

                    @default
                    <td>{{ $finding->$key }}</td>
                    @endswitch
                    @endforeach
                </tr>
                @endforeach
            </thead>
        </table>
    </div>
    @endif

</div>

@include('utility.script.tooltip')
<script>
    const created_at = <?php echo json_encode($created_at) ?>;
    const nik = <?php echo json_encode($nik) ?>;
    const footer = (tooltipItems) => {
        return 'By: ' + nik[tooltipItems[0].dataIndex];
    };

    // CHARTJS MOTOR_STATUS AND TEMPERATURE
    var ctxt = document.getElementById('temperature').getContext('2d');
    var temperature = new Chart(ctxt, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                    data: <?php echo json_encode($temperature_de) ?>,
                    label: "Temp DE",
                    borderColor: "rgb(62,149,205)",
                    backgroundColor: "rgb(62,149,205)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($temperature_body) ?>,
                    label: "Temp Body",
                    borderColor: "rgb(196,88,180)",
                    backgroundColor: "rgb(196,88,180)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($temperature_nde) ?>,
                    label: "Temp NDE",
                    borderColor: "rgb(80,80,80)",
                    backgroundColor: "rgb(80,80,80)",
                    fill: false,
                    tension: 0.3,
                },
                {
                    type: 'line',
                    data: <?php echo json_encode($motor_status) ?>,
                    label: "Motor Status",
                    borderColor: "rgb(171, 210, 182)",
                    backgroundColor: "rgb(171, 210, 182, 0.5)",
                    stepped: 'middle',
                    yAxisID: 'y2',
                }
            ]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
            },
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    // max: 150,
                    ticks: {
                        // stepSize: 50,
                        callback: function(value, index, ticks) {
                            return value + "°C";
                        }
                    }
                },
                y2: {
                    type: 'category',
                    labels: ['Run', 'Stop'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                }
            },
        },
    });
    temperature.canvas.parentNode.style.height = '350px';
    temperature.options.plugins.legend.position = "bottom";
    // CHARTJS MOTOR_STATUS AND TEMPERATURE

    // CHARTJS VIBRATION AND NOISE DE
    var ctxvde = document.getElementById('vibration_de').getContext('2d');
    var vibration_de = new Chart(ctxvde, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                    data: <?php echo json_encode($vibration_de_vertical_value) ?>,
                    label: "Vertical",
                    borderColor: "rgb(62,149,205)",
                    backgroundColor: "rgb(62,149,205)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($vibration_de_horizontal_value) ?>,
                    label: "Horizontal",
                    borderColor: "rgb(60,186,159)",
                    backgroundColor: "rgb(60,186,159)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($vibration_de_axial_value) ?>,
                    label: "Axial",
                    borderColor: "rgb(196,88,180)",
                    backgroundColor: "rgb(196,88,180)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($vibration_de_frame_value) ?>,
                    label: "Frame",
                    borderColor: "rgb(80,80,80)",
                    backgroundColor: "rgb(80,80,80)",
                    fill: false,
                    tension: 0.3,
                },
                {
                    type: 'line',
                    data: <?php echo json_encode($noise_de) ?>,
                    label: "Noise",
                    borderColor: "rgb(171, 210, 182)",
                    backgroundColor: "rgb(171, 210, 182, 0.5)",
                    stepped: 'middle',
                    yAxisID: 'y2',
                }
            ]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
            },
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    title: {
                        display: true,
                        text: 'mm/s',
                    },
                    // min: vibration_de_min,
                    // max: vibration_de_max,
                    // ticks: {
                    //     stepSize: vibration_de_step,
                    // },
                },
                y2: {
                    type: 'category',
                    labels: ['Noisy', 'Good'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
            },
        }
    });
    vibration_de.canvas.parentNode.style.height = '300px';
    vibration_de.options.plugins.legend.position = "bottom";
    // CHARTJS VIBRATION DE

    // CHARTJS VIBRATION AND NOISE NDE
    var ctxvde = document.getElementById('vibration_nde').getContext('2d');
    var vibration_nde = new Chart(ctxvde, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                    data: <?php echo json_encode($vibration_nde_vertical_value) ?>,
                    label: "Vertical",
                    borderColor: "rgb(62,149,205)",
                    backgroundColor: "rgb(62,149,205)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($vibration_nde_horizontal_value) ?>,
                    label: "Horizontal",
                    borderColor: "rgb(60,186,159)",
                    backgroundColor: "rgb(60,186,159)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($vibration_nde_frame_value) ?>,
                    label: "Frame",
                    borderColor: "rgb(80,80,80)",
                    backgroundColor: "rgb(80,80,80)",
                    fill: false,
                    tension: 0.3,
                },
                {
                    type: 'line',
                    data: <?php echo json_encode($noise_nde) ?>,
                    label: "Noise",
                    borderColor: "rgb(171, 210, 182)",
                    backgroundColor: "rgb(171, 210, 182, 0.5)",
                    stepped: 'middle',
                    yAxisID: 'y2',
                }
            ]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
            },
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    title: {
                        display: true,
                        text: 'mm/s',
                    },
                    // min: vibration_nde_min,
                    // max: vibration_nde_max,
                    // ticks: {
                    //     stepSize: vibration_nde_step,
                    // },
                },
                y2: {
                    type: 'category',
                    labels: ['Noisy', 'Good'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
            },
        }
    });
    vibration_nde.canvas.parentNode.style.height = '300px';
    vibration_nde.options.plugins.legend.position = "bottom";
    // CHARTJS VIBRATION NDE

    // CHARTJS GREASING
    var ctxg = document.getElementById('number_of_greasing').getContext('2d');
    var greasing = new Chart(ctxg, {
        type: 'bar',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($number_of_greasing) ?>,
                label: "Greasing",
                borderColor: "rgb(60,176,255)",
                backgroundColor: "rgb(60,176,255)",
                fill: false
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
            },
            maintainAspectRatio: false,
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Pump (0.56 ~ 3.10 grams per pump)',
                    },
                    min: 0,
                    max: 200,
                    ticks: {
                        stepSize: 50,
                    },
                }
            }
        }
    });
    greasing.canvas.parentNode.style.height = '300px';
    // console.info(greasing.options.plugins.tooltip);
    // CHARTJS GREASING
</script>

@include('utility.suffix')