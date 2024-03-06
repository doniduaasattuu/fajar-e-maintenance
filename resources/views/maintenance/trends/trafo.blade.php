<x-app-layout>

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Primary current"' />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Secondary current"' />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Voltage"' />

    <x-checking-form.image.trafo />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Temperature"' />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Oil level"' />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Silica gel"' />

    <x-trend.canvas :equipment_name='$equipment' :canvas_id='"Miscellaneous"' />

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
        const grid_color = '#303133';

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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        },
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        },
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                },
            },
        });

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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        },
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                },
            },
        });

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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        },
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                },
            }
        });

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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        },
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                    y1: {
                        type: 'category',
                        labels: ['No leaks', 'Leaks'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                },
            }
        });

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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
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
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
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
                    x: {
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                    y1: {
                        type: 'category',
                        labels: ['Clean', 'Dirty'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                    y2: {
                        type: 'category',
                        labels: ['Normal', 'Abnormal'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                    y3: {
                        type: 'category',
                        labels: ['No loose', 'Loose'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                    y4: {
                        type: 'category',
                        labels: ['No leaks', 'Leaks'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        grid: {
                            color: function(context) {
                                return grid_color;
                            },
                        },
                    },
                },
            }
        });
    </script>

</x-app-layout>