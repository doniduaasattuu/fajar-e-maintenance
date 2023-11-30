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
            <h4 class="text-break">Primary Current of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_primary_current"></canvas>
            </div>
        </div>

        <!-- SECONDARY CURRENT -->
        <div class="text-center">
            <h4 class="text-break">Secondary Current of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_secondary_current"></canvas>
            </div>
        </div>

        <!-- VOLTAGE -->
        <div class="text-center">
            <h4 class="text-break">Voltage of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_voltage"></canvas>
            </div>
        </div>

        <!-- TEMPERATURE -->
        <div class="text-center">
            <h4 class="text-break">Temperature of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_temperature"></canvas>
            </div>
        </div>

        <!-- NOISE -->
        <div class="text-center">
            <h4 class="text-break">Noise of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_noise"></canvas>
            </div>
        </div>

        <!-- SILICA GEL -->
        <div class="text-center">
            <h4 class="text-break">Silica Gel of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_silica_gel"></canvas>
            </div>
        </div>

        <!-- EARTHING CONNECTION -->
        <div class="text-center">
            <h4 class="text-break">Earthing Connection of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_earthing_connection"></canvas>
            </div>
        </div>

        <!-- OIL LEAKAGE -->
        <div class="text-center">
            <h4 class="text-break">Oil Leakage of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_oil_leakage"></canvas>
            </div>
        </div>

        <!-- OIL LEVEL -->
        <div class="text-center">
            <h4 class="text-break">Oil Level of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_oil_level"></canvas>
            </div>
        </div>

        <!-- BLOWER CONDITION -->
        <div class="text-center">
            <h4 class="text-break">Blower Condition of {{ $sort_field }}</h4>
            <div class="chart-container mb-4" style="position: relative;">
                <canvas id="canvas_blower_condition"></canvas>
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
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: primary_current_phase_s,
                        label: "Phase S",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: primary_current_phase_t,
                        label: "Phase T",
                        borderColor: "rgb(196,88,180)",
                        backgroundColor: "rgb(196,88,180)",
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
                            title: {
                                display: true,
                                text: 'Amps',
                            },
                        },
                    },
                }
            });
            canvas_primary_current.canvas.parentNode.style.height = '300px';
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
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_current_phase_s,
                        label: "Phase S",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_current_phase_t,
                        label: "Phase T",
                        borderColor: "rgb(196,88,180)",
                        backgroundColor: "rgb(196,88,180)",
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
                            title: {
                                display: true,
                                text: 'Amps',
                            },
                        },
                    },
                }
            });
            canvas_secondary_current.canvas.parentNode.style.height = '300px';
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
                        label: "Primary Voltage",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: secondary_voltage,
                        label: "Secondary Voltage",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
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
                            title: {
                                display: true,
                                text: 'Volt',
                            },
                        },
                    },
                }
            });
            canvas_voltage.canvas.parentNode.style.height = '300px';
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
                        label: "Oil Temperature",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: winding_temperature,
                        label: "Winding Temperature",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
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
                            title: {
                                display: true,
                                text: '°C',
                            },
                        },
                    },
                }
            });
            canvas_temperature.canvas.parentNode.style.height = '300px';
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
            canvas_noise.canvas.parentNode.style.height = '300px';
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
            canvas_silica_gel.canvas.parentNode.style.height = '300px';
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
                        label: "Earthin Connection",
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
            canvas_earthing_connection.canvas.parentNode.style.height = '300px';
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
            canvas_oil_leakage.canvas.parentNode.style.height = '300px';
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
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
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
            canvas_oil_level.canvas.parentNode.style.height = '300px';
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
            canvas_blower_condition.canvas.parentNode.style.height = '300px';
            canvas_blower_condition.options.plugins.legend.position = "bottom";
            // CHARTJS BLOWER CONDITION
        </script>
</body>

</html>