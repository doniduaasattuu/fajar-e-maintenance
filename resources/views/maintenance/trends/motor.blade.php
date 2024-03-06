<x-app-layout>

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Temperature"' />

    <x-checking-form.image.motor-temperature />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Vibration DE"' />
    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Vibration NDE"' />

    <x-checking-form.image.motor-vibration />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Number of greasing"' />

    {{-- FINDINGS --}}
    @if ( (count($findings) > 0) && !is_null($findings))
    <x-trend.findings :findings='$findings' :equipment='$equipment' />
    @endif

    <script type="module">
        const created_at = <?php echo json_encode($created_at) ?>;
        const nik = <?php echo json_encode($nik) ?>;
        const footer = (tooltipItems) => {
            return 'By: ' + nik[tooltipItems[0].dataIndex];
        };

        // TEMPERATURE
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
                    legend: {
                        position: "bottom",
                    }
                },
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
                    y: {
                        type: 'linear',
                        position: 'left',
                        stack: 'demo',
                        ticks: {
                            callback: function(value, index, ticks) {
                                return value + "°C";
                            }
                        },
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
                    y2: {
                        type: 'category',
                        labels: ['Run', 'Stop'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    }
                },
            },
        });

        // VIBRATION DE
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
                    x: {
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
                    y: {
                        type: 'linear',
                        position: 'left',
                        stack: 'demo',
                        title: {
                            display: true,
                            text: 'mm/s',
                        },
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
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
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
                },
            }
        });

        // VIBRATION NDE
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
                    x: {
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
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
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
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

        // GREASING
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
                    x: {
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
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
                        grid: {
                            color: function(context) {
                                return '#303133';
                            },
                        },
                    },
                }
            }
        });
    </script>

</x-app-layout>