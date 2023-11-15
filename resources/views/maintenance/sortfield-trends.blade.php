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
        <div class="text-center">
            <h4>Temperature of {{ $sort_field }}</h4>

            <div class="chart-container" style="position: relative;">
                <canvas id="temperature"></canvas>
            </div>
            <div class="row mt-2">
                <div class="col-md">
                    <figure>
                        <img class="img-fluid" src="/images/left-side.jpeg" alt="Left Side">
                        <figcaption class="figure-caption text-center">Left side</figcaption>
                    </figure>
                </div>
                <div class="col-md">
                    <figure>
                        <img class="img-fluid" src="/images/front-side.jpeg" alt="Front Side">
                        <figcaption class="figure-caption text-center">Front side</figcaption>
                    </figure>
                </div>
            </div>

            <div class="mb-5">
                <div class="col-md">
                    <figure>
                        <img class="img-fluid mx-auto d-block" src="/images/temp_iso_IEC_60085.png" alt="Temperature">
                        <figcaption class="figure-caption text-center">IEC 60085</figcaption>
                    </figure>
                </div>
            </div>

            <div class="mt-3 text-center">
                <div>
                    <h4>Vibration DE of {{ $sort_field }}</h4>
                    <div class="chart-container" style="position: relative;">
                        <canvas id="vibration_de"></canvas>
                    </div>
                </div>
                <div class="mt-3">
                    <h4>Vibration NDE of {{ $sort_field }}</h4>
                    <div class="chart-container" style="position: relative;">
                        <canvas id="vibration_nde"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mt-4">
                        <figure>
                            <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Vibration">
                            <figcaption id="figcaption_vibration" class="figure-caption text-center">Vibration standard</figcaption>
                        </figure>
                    </div>
                    <div class="col-md">
                        <figure>
                            <img class="img-fluid mx-auto d-block" src="/images/vibrations-checking-guide.png" alt="Vibration checking guide">
                            <figcaption id="figcaption_vibration_checking_guide" class="figure-caption text-center">Vibrations checking guide</figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <div id="number_of_greasing_display" class="mt-3 mb-5 text-center">
                <h4>Number of Greasing {{ $sort_field }}</h4>
                <div class="chart-container" style="position: relative;">
                    <canvas id="number_of_greasing"></canvas>
                </div>
            </div>

            <div id="findings">
                <div class="mt-3 mb-3 text-center">
                    <h4 class="mb-0">Findings Log</h4>
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

        </div>

        <script>
            let date = <?php echo json_encode($date_category) ?>;
            let length_of_data = <?php echo count($date_category) ?>;
            let checked_by = <?php echo json_encode($checked_by) ?>;
            let motor_status = <?php echo json_encode($motor_status) ?>;
            motor_status = motor_status.map(changeNotRunnningToStop);

            function changeNotRunnningToStop(status) {
                if (status == "Not Running") {
                    return "Stop";
                } else if (status == "Running") {
                    return "Run"
                };
            }
            // console.info(motor_status);

            // TEMPERATURE
            let temp_de = <?php echo json_encode($temperature_de) ?>;
            let temp_body = <?php echo json_encode($temperature_body) ?>;
            let temp_nde = <?php echo json_encode($temperature_nde) ?>;

            // VIBRATION
            let vibration_de_vertical_value = <?php echo json_encode($vibration_de_vertical_value) ?>;
            let vibration_de_vertical_desc = <?php echo json_encode($vibration_de_vertical_desc) ?>;
            let vibration_de_horizontal_value = <?php echo json_encode($vibration_de_horizontal_value) ?>;
            let vibration_de_horizontal_desc = <?php echo json_encode($vibration_de_horizontal_desc) ?>;
            let vibration_de_axial_value = <?php echo json_encode($vibration_de_axial_value) ?>;
            let vibration_de_axial_desc = <?php echo json_encode($vibration_de_axial_desc) ?>;
            let vibration_de_frame_value = <?php echo json_encode($vibration_de_frame_value) ?>;
            let vibration_de_frame_desc = <?php echo json_encode($vibration_de_frame_desc) ?>;

            let vibration_nde_vertical_value = <?php echo json_encode($vibration_nde_vertical_value) ?>;
            let vibration_nde_vertical_desc = <?php echo json_encode($vibration_nde_vertical_desc) ?>;
            let vibration_nde_horizontal_value = <?php echo json_encode($vibration_nde_horizontal_value) ?>;
            let vibration_nde_horizontal_desc = <?php echo json_encode($vibration_nde_horizontal_desc) ?>;
            let vibration_nde_frame_value = <?php echo json_encode($vibration_nde_frame_value) ?>;
            let vibration_nde_frame_desc = <?php echo json_encode($vibration_nde_frame_desc) ?>;

            let vibration_min = -5;
            let vibration_max = 5;
            let vibration_step = 1;

            //  LINE CHARTS TYPES
            let chart_types = "line";
            if (date.length <= 3) {
                chart_types = "bar"
            }

            // DYNAMIC MAX RANGE FOR VIBRATION START
            function moreFive(age) {
                return age > 5;
            }

            function moreTen(age) {
                return age > 10;
            }

            function moreTwenty(age) {
                return age > 20;
            }

            let deFive = vibration_de_vertical_value.filter(moreFive)
            let ndeFive = vibration_nde_vertical_value.filter(moreFive)

            let deTen = vibration_de_vertical_value.filter(moreTen)
            let ndeTen = vibration_nde_vertical_value.filter(moreTen)

            let deTwenty = vibration_de_vertical_value.filter(moreTwenty)
            let ndeTwenty = vibration_nde_vertical_value.filter(moreTwenty)

            if ((deFive.length >= 1) || (ndeFive.length >= 1)) {
                vibration_max = 10
                vibration_step = 2
                vibration_min = -10
            }
            if ((deTen.length >= 1) || (ndeTen.length >= 1)) {
                vibration_step = 5
                vibration_max = 20
            }
            if ((deTwenty.length >= 1) || (ndeTwenty.length >= 1)) {
                vibration_min = -15
                vibration_step = 15
                vibration_max = 45
            }
            // DYNAMIC MAX RANGE FOR VIBRATION END

            // NUMBER OF GREASING
            let number_of_greasing = <?php echo json_encode($number_of_greasing) ?>;

            const footer = (tooltipItems) => {
                return 'By: ' + checked_by[tooltipItems[0].dataIndex];
            };

            // CHARTJS MOTOR_STATUS AND TEMPERATURE
            var ctxt = document.getElementById('temperature').getContext('2d');
            var temperature = new Chart(ctxt, {
                type: chart_types,
                data: {
                    labels: date,
                    datasets: [{
                            data: temp_de,
                            label: "Temp DE",
                            borderColor: "rgb(62,149,205)",
                            backgroundColor: "rgb(62,149,205)",
                            fill: false,
                            tension: 0.3,
                        }, {
                            data: temp_body,
                            label: "Temp Body",
                            borderColor: "rgb(196,88,180)",
                            backgroundColor: "rgb(196,88,180)",
                            fill: false,
                            tension: 0.3,
                        }, {
                            data: temp_nde,
                            label: "Temp NDE",
                            borderColor: "rgb(80,80,80)",
                            backgroundColor: "rgb(80,80,80)",
                            fill: false,
                            tension: 0.3,
                        },
                        {
                            type: 'line',
                            data: motor_status,
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
                            max: 150,
                            ticks: {
                                stepSize: 50,
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

            // CHARTJS VIBRATION DE
            var ctxv = document.getElementById('vibration_de').getContext('2d');
            var vibration_de = new Chart(ctxv, {
                type: chart_types,
                data: {
                    labels: date,
                    datasets: [{
                        data: vibration_de_vertical_value,
                        label: "Vertical",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: vibration_de_horizontal_value,
                        label: "Horizontal",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: vibration_de_axial_value,
                        label: "Axial",
                        borderColor: "rgb(196,88,180)",
                        backgroundColor: "rgb(196,88,180)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: vibration_de_frame_value,
                        label: "Frame",
                        borderColor: "rgb(80,80,80)",
                        backgroundColor: "rgb(80,80,80)",
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
                                text: 'mm/s',
                            },
                            min: vibration_min,
                            max: vibration_max,
                            ticks: {
                                stepSize: vibration_step,
                            },
                        },
                        // y2: {
                        //     type: 'category',
                        //     labels: ['Unacceptable', 'Unsatisfactory', 'Satisfactory', 'Good'],
                        //     offset: true,
                        //     position: 'left',
                        //     stack: 'demo',
                        //     stackWeight: 1,
                        // },
                    },
                }
            });
            vibration_de.canvas.parentNode.style.height = '300px';
            vibration_de.options.plugins.legend.position = "bottom";
            // CHARTJS VIBRATION DE

            // CHARTJS VIBRATION DE
            var ctxv = document.getElementById('vibration_nde').getContext('2d');
            var vibration_nde = new Chart(ctxv, {
                type: chart_types,
                data: {
                    labels: date,
                    datasets: [{
                        data: vibration_nde_vertical_value,
                        label: "Vertical",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: vibration_nde_horizontal_value,
                        label: "Horizontal",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
                        fill: false,
                        tension: 0.3,
                    }, {
                        data: vibration_nde_frame_value,
                        label: "Frame",
                        borderColor: "rgb(80,80,80)",
                        backgroundColor: "rgb(80,80,80)",
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
                                text: 'mm/s',
                            },
                            min: vibration_min,
                            max: vibration_max,
                            ticks: {
                                stepSize: vibration_step,
                            },
                        },
                    },
                }
            });
            vibration_nde.canvas.parentNode.style.height = '300px';
            vibration_nde.options.plugins.legend.position = "bottom";
            // CHARTJS VIBRATION DE

            // CHARTJS GREASING
            var ctxg = document.getElementById('number_of_greasing').getContext('2d');
            var greasing = new Chart(ctxg, {
                type: 'bar',
                data: {
                    labels: date,
                    checked_by: checked_by,
                    datasets: [{
                        data: number_of_greasing,
                        label: "Number of Greasing",
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
                                text: '0.56 ~ 3.10 grams per Pump',
                            },
                            min: 0,
                            max: 150,
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

        <script>
            // BOOTSTRAP TOOLTIPS
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
</body>

</html>