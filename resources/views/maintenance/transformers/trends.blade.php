<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<style>
    .comment_row {
        font-family: 'Roboto Mono', monospace;
    }
</style>

<body>

    @include("utility.navbar")

    <div class="container-xl py-4">

        <!-- PRIMARY CURRENT -->
        <div class="text-center">
            <!-- <h4 class="text-break">Primary Current of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_primary_current"></canvas>
            </div>
        </div>

        <!-- SECONDARY CURRENT -->
        <div class="text-center">
            <!-- <h4 class="text-break">Secondary Current of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_secondary_current"></canvas>
            </div>
        </div>

        <!-- VOLTAGE -->
        <div class="text-center">
            <!-- <h4 class="text-break">Voltage of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_voltage"></canvas>
            </div>
        </div>

        <!-- TEMPERATURE -->
        <div class="text-center">
            <!-- <h4 class="text-break">Temperature of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_temperature"></canvas>
            </div>
        </div>

        <!-- NOISE -->
        <div class="text-center">
            <!-- <h4 class="text-break">Noise of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_noise"></canvas>
            </div>
        </div>

        <!-- SILICA GEL -->
        <div class="text-center">
            <!-- <h4 class="text-break">Silica Gel of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_silica_gel"></canvas>
            </div>
        </div>

        <!-- EARTHING CONNECTION -->
        <div class="text-center">
            <!-- <h4 class="text-break">Earthing Connection of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_earthing_connection"></canvas>
            </div>
        </div>

        <!-- OIL LEAKAGE -->
        <div class="text-center">
            <!-- <h4 class="text-break">Oil Leakage of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_oil_leakage"></canvas>
            </div>
        </div>

        <!-- OIL LEVEL -->
        <div class="text-center">
            <!-- <h4 class="text-break">Oil Level of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_oil_level"></canvas>
            </div>
        </div>

        <!-- BLOWER CONDITION -->
        <div class="text-center">
            <!-- <h4 class="text-break">Blower Condition of {{ $sort_field }}</h4> -->
            <div class="card shadow p-3 chart-container mb-5" style="position: relative;">
                <canvas id="canvas_blower_condition"></canvas>
            </div>
        </div>

        <!-- FINDING -->
        <div id="findings">
            <div class="mt-3 mb-3 text-center">
                <h5 class="text-break mb-0">Findings Log of {{ $sort_field }}</h5>
                <div class="fs-6 text-secondary">The top one is the newest</div>
            </div>
            <div class="text-start">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Desc</th>
                            <th scope="col">Equipment</th>
                            <th scope="col">Reporter</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($comments as $comment )
                        <tr class="comment_row">
                            <td>{{ $i }}</td>
                            @foreach ($comment as $key => $value )

                            @if ($key == "nik")
                            @continue

                            @elseif ($key == "created_at")
                            <td>
                                <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $value }}">{{ date_format(date_create($value), "d-M-y") }}</div>
                            </td>

                            @elseif ($key == "user")
                            @if (strlen(explode(" ", $value['fullname'])[0]) < 3) <td>
                                <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $value['nik'] }} - {{ $value['fullname'] }}">{{ explode(" ", $value['fullname'])[1] }}</div>
                                </td>
                                @else
                                <td>
                                    <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $value['nik'] }} - {{ $value['fullname'] }}">{{ explode(" ", $value['fullname'])[0] }}</div>
                                </td>
                                @endif

                                @else
                                <td>{{ $value }}</td>
                                @endif

                                @endforeach
                        </tr>
                        @php
                        $i++
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            let date = <?php echo json_encode($date_category) ?>;
            let transformer_status = <?php echo json_encode($transformer_status) ?>;

            let primary_current_phase_r = <?php echo json_encode($primary_current_phase_r) ?>;
            let primary_current_phase_s = <?php echo json_encode($primary_current_phase_s) ?>;
            let primary_current_phase_t = <?php echo json_encode($primary_current_phase_t) ?>;

            let secondary_current_phase_r = <?php echo json_encode($secondary_current_phase_r) ?>;
            let secondary_current_phase_s = <?php echo json_encode($secondary_current_phase_s) ?>;
            let secondary_current_phase_t = <?php echo json_encode($secondary_current_phase_t) ?>;

            let primary_voltage = <?php echo json_encode($primary_voltage) ?>;
            let secondary_voltage = <?php echo json_encode($secondary_voltage) ?>;
            let oil_temperature = <?php echo json_encode($oil_temperature) ?>;
            let winding_temperature = <?php echo json_encode($winding_temperature) ?>;
            let clean_status = <?php echo json_encode($clean_status) ?>;
            let noise = <?php echo json_encode($noise) ?>;
            let silica_gel = <?php echo json_encode($silica_gel) ?>;
            let earthing_connection = <?php echo json_encode($earthing_connection) ?>;
            let oil_leakage = <?php echo json_encode($oil_leakage) ?>;
            let oil_level = <?php echo json_encode($oil_level) ?>;
            let blower_condition = <?php echo json_encode($blower_condition) ?>;
            let comments = <?php echo json_encode($comments) ?>;
            let checked_by = <?php echo json_encode($checked_by) ?>;
            let sort_field = <?php echo json_encode($sort_field) ?>;

            const footer = (tooltipItems) => {
                return 'By: ' + checked_by[tooltipItems[0].dataIndex];
            };

            // CHARTJS PRIMARY CURRENT
            var ctxpc = document.getElementById('canvas_primary_current').getContext('2d');
            var canvas_primary_current = new Chart(ctxpc, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: primary_current_phase_r,
                        label: "Phase R",
                        borderColor: "rgb(20, 20, 20)",
                        backgroundColor: "rgb(20, 20, 20)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: primary_current_phase_s,
                        label: "Phase S",
                        borderColor: "rgb(140, 96, 87)",
                        backgroundColor: "rgb(140, 96, 87)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: primary_current_phase_t,
                        label: "Phase T",
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
                        title: {
                            display: true,
                            text: "Primary Current " + sort_field,
                            font: {
                                size: 16
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
                                text: 'Amps',
                            },

                        },
                    },
                }
            });
            canvas_primary_current.canvas.parentNode.style.height = '350px';
            canvas_primary_current.options.plugins.legend.position = "bottom";
            // CHARTJS PRIMARY CURRENT

            // CHARTJS SECONDARY CURRENT
            var ctxsc = document.getElementById('canvas_secondary_current').getContext('2d');
            var canvas_secondary_current = new Chart(ctxsc, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: secondary_current_phase_r,
                        label: "Phase R",
                        borderColor: "rgb(20, 20, 20)",
                        backgroundColor: "rgb(20, 20, 20)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_current_phase_s,
                        label: "Phase S",
                        borderColor: "rgb(140, 96, 87)",
                        backgroundColor: "rgb(140, 96, 87)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_current_phase_t,
                        label: "Phase T",
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
                        title: {
                            display: true,
                            text: "Secondary Current " + sort_field,
                            font: {
                                size: 16
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
                                text: 'Amps',
                            },
                        },
                    },
                }
            });
            canvas_secondary_current.canvas.parentNode.style.height = '350px';
            canvas_secondary_current.options.plugins.legend.position = "bottom";
            // CHARTJS SECONDARY CURRENT

            // CHARTJS VOLTAGE
            var ctxv = document.getElementById('canvas_voltage').getContext('2d');
            var canvas_voltage = new Chart(ctxv, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: primary_voltage,
                        label: "Primary",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_voltage,
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
                        title: {
                            display: true,
                            text: "Voltage " + sort_field,
                            font: {
                                size: 16
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
                                text: 'Volt',
                            },
                        },
                    },
                }
            });
            canvas_voltage.canvas.parentNode.style.height = '350px';
            canvas_voltage.options.plugins.legend.position = "bottom";
            // CHARTJS VOLTAGE

            // CHARTJS TEMPERATURE
            var ctxt = document.getElementById('canvas_temperature').getContext('2d');
            var canvas_temperature = new Chart(ctxt, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: oil_temperature,
                        label: "Oil",
                        borderColor: "rgb(245, 187, 0)",
                        backgroundColor: "rgb(245, 187, 0)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: winding_temperature,
                        label: "Winding",
                        borderColor: "rgb(255, 78, 0)",
                        backgroundColor: "rgb(255, 78, 0)",
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
                        title: {
                            display: true,
                            text: "Temperature " + sort_field,
                            font: {
                                size: 16
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
                                text: '°C',
                            },
                        },
                    },
                }
            });
            canvas_temperature.canvas.parentNode.style.height = '350px';
            canvas_temperature.options.plugins.legend.position = "bottom";
            // CHARTJS TEMPERATURE

            // CHARTJS NOISE
            var ctxn = document.getElementById('canvas_noise').getContext('2d');
            var canvas_noise = new Chart(ctxn, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: noise,
                        label: "Noise",
                        borderColor: "rgb(171, 210, 182)",
                        backgroundColor: "rgb(171, 210, 182)",
                        fill: false,
                        tension: 0.3,
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
                        title: {
                            display: true,
                            text: "Noise " + sort_field,
                            font: {
                                size: 16,
                            },
                        },
                    },
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'category',
                            labels: ['Normal', 'Abnormal'],
                            offset: true,
                            position: 'left',
                            stack: 'demo',
                            stackWeight: 1,
                        },
                    },
                }
            });
            canvas_noise.canvas.parentNode.style.height = '250px';
            canvas_noise.options.plugins.legend.position = "bottom";
            // CHARTJS NOISE

            // CHARTJS SILICA GEL
            var ctxsg = document.getElementById('canvas_silica_gel').getContext('2d');
            var canvas_silica_gel = new Chart(ctxsg, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: silica_gel,
                        label: "Silica Gel",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
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
                        title: {
                            display: true,
                            text: "Silica Gel " + sort_field,
                            font: {
                                size: 16
                            },
                        },
                    },
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'category',
                            labels: ['Dark Blue', 'Light Blue', 'Pink', 'Brown'],
                            offset: true,
                            position: 'left',
                            stack: 'demo',
                            stackWeight: 1,
                        },
                    },
                }
            });
            canvas_silica_gel.canvas.parentNode.style.height = '350px';
            canvas_silica_gel.options.plugins.legend.position = "bottom";
            // CHARTJS SILICA GEL

            // CHARTJS SILICA GEL
            var ctxsec = document.getElementById('canvas_earthing_connection').getContext('2d');
            var canvas_earthing_connection = new Chart(ctxsec, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: earthing_connection,
                        label: "Earthing Connection",
                        borderColor: "rgb(255, 16, 83)",
                        backgroundColor: "rgb(255, 16, 83)",
                        fill: false,
                        tension: 0.3,
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
                        title: {
                            display: true,
                            text: "Earthing Connection " + sort_field,
                            font: {
                                size: 16
                            },
                        },
                    },
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'category',
                            labels: ['Tight', 'Loose'],
                            offset: true,
                            position: 'left',
                            stack: 'demo',
                            stackWeight: 1,
                        },
                    },
                }
            });
            canvas_earthing_connection.canvas.parentNode.style.height = '250px';
            canvas_earthing_connection.options.plugins.legend.position = "bottom";
            // CHARTJS SILICA GEL

            // CHARTJS OIL LEAKAGE
            var ctxsol = document.getElementById('canvas_oil_leakage').getContext('2d');
            var canvas_oil_leakage = new Chart(ctxsol, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: oil_leakage,
                        label: "Oil Leakage",
                        borderColor: "rgb(176, 213, 96)",
                        backgroundColor: "rgb(176, 213, 96)",
                        fill: false,
                        tension: 0.3,
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
                        title: {
                            display: true,
                            text: "Oil Leakage " + sort_field,
                            font: {
                                size: 16
                            },
                        },
                    },
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'category',
                            labels: ['Leaks', 'No Leaks'],
                            offset: true,
                            position: 'left',
                            stack: 'demo',
                            stackWeight: 1,
                        },
                    },
                }
            });
            canvas_oil_leakage.canvas.parentNode.style.height = '250px';
            canvas_oil_leakage.options.plugins.legend.position = "bottom";
            // CHARTJS OIL LEAKAGE

            // CHARTJS OIL LEVEL
            var ctxsolv = document.getElementById('canvas_oil_level').getContext('2d');
            var canvas_oil_level = new Chart(ctxsolv, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: oil_level,
                        label: "Oil Level",
                        borderColor: "rgb(245, 187, 0)",
                        backgroundColor: "rgba(245, 187, 0, 0.7)",
                        fill: true,
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
                        title: {
                            display: true,
                            text: "Oil Level " + sort_field,
                            font: {
                                size: 16
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
                            ticks: {
                                stepSize: 20,
                                callback: function(value) {
                                    return value + "%";
                                }
                            },
                        },
                    },
                }
            });
            canvas_oil_level.canvas.parentNode.style.height = '350px';
            canvas_oil_level.options.plugins.legend.position = "bottom";
            // CHARTJS OIL LEVEL

            // CHARTJS BLOWER CONDITION
            var ctxsbc = document.getElementById('canvas_blower_condition').getContext('2d');
            var canvas_blower_condition = new Chart(ctxsbc, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        data: blower_condition,
                        label: "Blower Condition",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
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
                        title: {
                            display: true,
                            text: "Blower Condition " + sort_field,
                            font: {
                                size: 16
                            },
                        },
                    },
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'category',
                            labels: ['Normal', 'Abnormal'],
                            offset: true,
                            position: 'left',
                            stack: 'demo',
                            stackWeight: 1,
                        },
                    },
                }
            });
            canvas_blower_condition.canvas.parentNode.style.height = '250px';
            canvas_blower_condition.options.plugins.legend.position = "bottom";
            // CHARTJS BLOWER CONDITION
        </script>

        <script>
            // BOOTSTRAP TOOLTIPS
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

            // HIDDEN FINDINGS LOG IF EMPTY
            const findings = document.getElementById("findings");
            let finding_comments = <?php echo json_encode($comments) ?>;
            if (finding_comments.length == 0) {
                findings.style.display = "none";
            }

            // SWAP COMMENT COLUMN
            const comment_rows = document.getElementsByClassName('comment_row');
            for (let i = 0; i < comment_rows.length; i++) {
                let date = comment_rows[i].lastElementChild.previousElementSibling;
                comment_rows[i].removeChild(date)
                comment_rows[i].appendChild(date)
            }
        </script>
</body>

</html>