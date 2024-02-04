@include('utility.prefix')

<div class="py-4" style="min-width: 350px;">

    {{-- PRIMARY CURRENT --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Primary current of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="primary_current"></canvas>
        </div>
    </div>

    {{-- SECONDARY CURRENT --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Secondary current of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="secondary_current"></canvas>
        </div>
    </div>

    {{-- VOLTAGE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Voltage of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="voltage"></canvas>
        </div>
    </div>

    {{-- IMAGE FOR TRAFO --}}
    @include('utility.image-trafo')

    {{-- TEMPERATURE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Temperature of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="temperature"></canvas>
        </div>
    </div>

    {{-- OIL LEVEL AND LEAKAGE --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Oil level of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="oil_level"></canvas>
        </div>
    </div>

    {{-- SILICA GEL --}}
    <div class="mb-3">
        <h6 class="text-center text-secondary">Silica gel of {{ $equipment }}</h6>
        <div class="chart-container" style="position: relative;">
            <canvas id="silica_gel"></canvas>
        </div>
    </div>

    {{-- MISCELLANEOUS --}}
    <div class="mb-3">
        <!-- <h6 class="text-center text-secondary">Miscellaneous of {{ $equipment }}</h6> -->
        <div class="chart-container" style="position: relative;">
            <canvas id="miscellaneous"></canvas>
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
                    <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $finding->$key }}">{{ $trafoService->formatDDMMYY($finding->$key) }}</td>
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

    // TRAFO PRIMARY CURRENT
    var pcurr = document.getElementById('primary_current').getContext('2d');
    var primary_current = new Chart(pcurr, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                    data: <?php echo json_encode($primary_current_phase_r) ?>,
                    label: "Primary R",
                    borderColor: "rgb(20, 20, 20)",
                    backgroundColor: "rgb(20, 20, 20)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($primary_current_phase_s) ?>,
                    label: "Primary S",
                    borderColor: "rgb(140, 96, 87)",
                    backgroundColor: "rgb(140, 96, 87)",
                    fill: false,
                    tension: 0.3,
                }, {
                    data: <?php echo json_encode($primary_current_phase_t) ?>,
                    label: "Primary T",
                    borderColor: "rgb(197, 195, 198)",
                    backgroundColor: "rgb(197, 195, 198)",
                    fill: false,
                    tension: 0.3,
                },
                {
                    type: 'line',
                    data: <?php echo json_encode($trafo_status) ?>,
                    label: "Trafo Status",
                    borderColor: "rgb(171, 210, 182)",
                    backgroundColor: "rgb(171, 210, 182)",
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
                        stepSize: 100,
                        callback: function(value, index, ticks) {
                            return value + " A";
                        }
                    }
                },
                y2: {
                    type: 'category',
                    labels: ['Online', 'Offline'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                }
            },
        },
    });
    primary_current.canvas.parentNode.style.height = '350px';
    primary_current.options.plugins.legend.position = "bottom";
    // TRAFO PRIMARY CURRENT 

    // TRAFO SECONDARY CURRENT
    var scurr = document.getElementById('secondary_current').getContext('2d');
    var secondary_current = new Chart(scurr, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($secondary_current_phase_r) ?>,
                label: "Secondary R",
                borderColor: "rgb(20, 20, 20)",
                backgroundColor: "rgb(20, 20, 20)",
                fill: false,
                tension: 0.3,
            }, {
                data: <?php echo json_encode($secondary_current_phase_s) ?>,
                label: "Secondary S",
                borderColor: "rgb(140, 96, 87)",
                backgroundColor: "rgb(140, 96, 87)",
                fill: false,
                tension: 0.3,
            }, {
                data: <?php echo json_encode($secondary_current_phase_t) ?>,
                label: "Secondary T",
                borderColor: "rgb(197, 195, 198)",
                backgroundColor: "rgb(197, 195, 198)",
                fill: false,
                tension: 0.3,
            }, ]
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
                            return value + " A";
                        }
                    }
                },
            },
        },
    });
    secondary_current.canvas.parentNode.style.height = '350px';
    secondary_current.options.plugins.legend.position = "bottom";
    // TRAFO SECONDARY CURRENT 

    // TRAFO VOLTAGE
    var tvolt = document.getElementById('voltage').getContext('2d');
    var voltage = new Chart(tvolt, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($primary_voltage) ?>,
                label: "Primary",
                borderColor: "rgb(62,149,205)",
                backgroundColor: "rgb(62,149,205)",
                fill: false,
                tension: 0.3,
            }, {
                data: <?php echo json_encode($secondary_voltage) ?>,
                label: "Secondary",
                borderColor: "rgb(231, 90, 124)",
                backgroundColor: "rgb(231, 90, 124)",
                fill: false,
                tension: 0.3,
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
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    // max: 150,
                    ticks: {
                        // stepSize: 50,
                        callback: function(value, index, ticks) {
                            return value + " V";
                        }
                    }
                },
            },
        },
    });
    voltage.canvas.parentNode.style.height = '350px';
    voltage.options.plugins.legend.position = "bottom";
    // TRAFO VOLTAGE

    // TRAFO TEMPERATURE
    var ttemp = document.getElementById('temperature').getContext('2d');
    var temperature = new Chart(ttemp, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($oil_temperature) ?>,
                label: "Oil",
                borderColor: "rgb(0, 159, 253)",
                backgroundColor: "rgb(0, 159, 253)",
                fill: false,
                tension: 0.3,
            }, {
                data: <?php echo json_encode($winding_temperature) ?>,
                label: "Winding",
                borderColor: "rgb(35, 37, 40)",
                backgroundColor: "rgb(35, 37, 40)",
                fill: false,
                tension: 0.3,
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
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    // title: {
                    //     display: true,
                    //     text: '°C',
                    // },
                    ticks: {
                        // stepSize: 50,
                        callback: function(value, index, ticks) {
                            return value + "°C";
                        }
                    }
                },
            },
        }
    });
    temperature.canvas.parentNode.style.height = '350px';
    temperature.options.plugins.legend.position = "bottom";
    // TRAFO TEMPERATURE

    // TRAFO OIL LEVEL
    var ttemp = document.getElementById('oil_level').getContext('2d');
    var oil_level = new Chart(ttemp, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                data: <?php echo json_encode($oil_level) ?>,
                label: "Conservator oil level",
                borderColor: "rgb(0, 159, 253)",
                backgroundColor: "rgb(0, 159, 253, 0.5)",
                fill: true,
                tension: 0.3,
            }, {
                type: 'line',
                data: <?php echo json_encode($oil_leakage) ?>,
                label: "Oil leakage",
                borderColor: "rgb(171, 210, 182)",
                backgroundColor: "rgb(171, 210, 182)",
                stepped: 'middle',
                yAxisID: 'y1',
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
                    type: 'linear',
                    position: 'left',
                    stack: 'demo',
                    min: 0,
                    max: 100,
                    // title: {
                    //     display: true,
                    //     text: '%',
                    // },
                    ticks: {
                        stepSize: 20,
                        callback: function(value, index, ticks) {
                            return value + '%';
                        }
                    }
                },
                y1: {
                    type: 'category',
                    labels: ['No leaks', 'Leaks'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
            },
        }
    });
    oil_level.canvas.parentNode.style.height = '350px';
    oil_level.options.plugins.legend.position = "bottom";
    // TRAFO OIL LEVEL

    // SILICA GEL
    var sgel = document.getElementById('silica_gel').getContext('2d');
    var silica_gel = new Chart(sgel, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                type: 'line',
                data: <?php echo json_encode($silica_gel) ?>,
                label: "Silica gel",
                borderColor: "rgb(125, 83, 222)",
                backgroundColor: "rgb(125, 83, 222)",
                stepped: 'middle',
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
                    type: 'category',
                    labels: ['Dark blue', 'Light blue', 'Pink', 'Brown'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                    // title: {
                    //     display: true,
                    //     text: '%',
                    // },
                    // ticks: {
                    //     stepSize: 20,
                    //     callback: function(value, index, ticks) {
                    //         return value + '%';
                    //     }
                    // }
                },
                // y1: {
                //     type: 'category',
                //     labels: ['Dark blue', 'Light blue', 'Pink', 'Brown'],
                //     offset: true,
                //     position: 'left',
                //     stack: 'demo',
                //     stackWeight: 1,
                // },
            },
        }
    });
    silica_gel.canvas.parentNode.style.height = '350px';
    silica_gel.options.plugins.legend.position = "bottom";
    // SILICA GEL

    // MISCELLANEOUS
    var ctxsbc = document.getElementById('miscellaneous').getContext('2d');
    var miscellaneous = new Chart(ctxsbc, {
        type: 'line',
        data: {
            labels: created_at,
            datasets: [{
                type: 'line',
                data: <?php echo json_encode($cleanliness) ?>,
                label: "Cleanliness",
                borderColor: "rgb(115, 137, 174)",
                backgroundColor: "rgb(115, 137, 174)",
                stepped: 'middle',
                yAxisID: 'y1',
            }, {
                type: 'line',
                data: <?php echo json_encode($noise) ?>,
                label: "Noise",
                borderColor: "rgb(224, 114, 164)",
                backgroundColor: "rgb(224, 114, 164)",
                stepped: 'middle',
                yAxisID: 'y2',
            }, {
                type: 'line',
                data: <?php echo json_encode($earthing_connection) ?>,
                label: "Earthing connection",
                borderColor: "rgb(151, 204, 4)",
                backgroundColor: "rgb(151, 204, 4)",
                stepped: 'middle',
                yAxisID: 'y3',
            }, {
                type: 'line',
                data: <?php echo json_encode($oil_leakage) ?>,
                label: "Oil leakage",
                borderColor: "rgb(244, 93, 1)",
                backgroundColor: "rgb(244, 93, 1)",
                stepped: 'middle',
                yAxisID: 'y4',
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        footer: footer
                    },
                },
                // title: {
                //     display: true,
                //     text: "Blower Condition " + sort_field,
                //     font: {
                //         size: 16
                //     },
                // },
            },
            maintainAspectRatio: false,
            scales: {
                y1: {
                    type: 'category',
                    labels: ['Clean', 'Dirty'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
                y2: {
                    type: 'category',
                    labels: ['Normal', 'Abnormal'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
                y3: {
                    type: 'category',
                    labels: ['No loose', 'Loose'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
                y4: {
                    type: 'category',
                    labels: ['No leaks', 'Leaks'],
                    offset: true,
                    position: 'left',
                    stack: 'demo',
                    stackWeight: 1,
                },
            },
        }
    });
    miscellaneous.canvas.parentNode.style.height = '350px';
    miscellaneous.options.plugins.legend.position = "top";
    // MISCELLANEOUS
</script>

@include('utility.suffix')