<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <p class="d-none" id="emo">{{ $emo }}</p>

    <div class="container-xl py-5">
        <div class="text-center">
            <h4>Temperature of {{ $emo }}</h4>
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
                <h4>Vibration of {{ $emo }}</h4>
                <div class="chart-container" style="position: relative;">
                    <canvas id="vibration"></canvas>
                </div>
                <div class="row mt-2">
                    <div class="col-md mt-3">
                        <figure>
                            <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Vibration">
                            <figcaption class="figure-caption text-center">Vibration standard</figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <div style="display: none;" id="number_of_greasing_display" class="mt-3 mb-5 text-center">
                <h4>Number of Greasing {{ $emo }}</h4>
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
                                <th scope="col">Description</th>
                                <th scope="col">Reporter</th>
                                <th class="text-end" scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($comments as $comment )
                            <tr>
                                <td>{{ $i }}</td>
                                @foreach ($comment as $key => $value )
                                @if ($key == "created_at")
                                <td class="text-end">{{ date_format(date_create($value), "d/m/y") }}</td>
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
            let emo = document.getElementById("emo").textContent;
            let date = <?php echo json_encode($date_category) ?>;
            let chart_types = "line";
            if (date.length <= 3) {
                chart_types = "bar"
            }
            // TEMPERATURE
            let temp_a = <?php echo json_encode($temperature_a) ?>;
            let temp_b = <?php echo json_encode($temperature_b) ?>;
            let temp_c = <?php echo json_encode($temperature_c) ?>;
            let temp_d = <?php echo json_encode($temperature_d) ?>;

            // VIBRATION
            let vibration_value_de = <?php echo json_encode($vibration_value_de) ?>;
            let vibration_value_nde = <?php echo json_encode($vibration_value_nde) ?>;
            let vibration_min = -5;
            let vibration_max = 5;
            let vibration_step = 1;

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

            let deFive = vibration_value_de.filter(moreFive)
            let ndeFive = vibration_value_nde.filter(moreFive)

            let deTen = vibration_value_de.filter(moreTen)
            let ndeTen = vibration_value_nde.filter(moreTen)

            let deTwenty = vibration_value_de.filter(moreTwenty)
            let ndeTwenty = vibration_value_nde.filter(moreTwenty)

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
            let nipple_grease = "<?php echo $nipple_grease ?>"
            let number_of_greasing = <?php echo json_encode($number_of_greasing) ?>;
            let number_of_greasing_display = document.getElementById("number_of_greasing_display");

            if (nipple_grease == "Available") {
                number_of_greasing_display.style.display = "block"
            }

            // CHARTJS TEMPERATURE
            var ctx = document.getElementById('temperature').getContext('2d');
            var temperature = new Chart(ctx, {
                type: chart_types,
                data: {
                    labels: date,
                    datasets: [{
                        data: temp_a,
                        label: "Point A",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false
                    }, {
                        data: temp_b,
                        label: "Point B",
                        borderColor: "rgb(196,88,180)",
                        backgroundColor: "rgb(196,88,180)",
                        fill: false
                    }, {
                        data: temp_c,
                        label: "Point C",
                        borderColor: "rgb(80,80,80)",
                        backgroundColor: "rgb(80,80,80)",
                        fill: false
                    }, {
                        data: temp_d,
                        label: "Point D",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",

                        fill: false
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: 200,
                                stepSize: 50,
                                callback: function(value, index, ticks) {
                                    return value + " °C";
                                }
                            }
                        }],
                    }
                }
            });
            temperature.canvas.parentNode.style.height = '300px';
            temperature.options.legend.position = "bottom";
            // CHARTJS TEMPERATURE

            // CHARTJS VIBRATION
            var ctx = document.getElementById('vibration').getContext('2d');
            var vibration = new Chart(ctx, {
                type: chart_types,
                data: {
                    labels: date,
                    datasets: [{
                        data: vibration_value_de,
                        label: "Vibration DE",
                        borderColor: "rgb(62,149,205)",
                        backgroundColor: "rgb(62,149,205)",
                        fill: false
                    }, {
                        data: vibration_value_nde,
                        label: "Vibration NDE",
                        borderColor: "rgb(60,186,159)",
                        backgroundColor: "rgb(60,186,159)",
                        fill: false
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: vibration_min,
                                max: vibration_max,
                                stepSize: vibration_step,
                                // callback: function(value, index, ticks) {
                                //     return value + " mm/s"
                                //     // ᵐᵐ/ˢ
                                // }
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'mm/s'
                            }
                        }],
                    },
                }
            });
            vibration.canvas.parentNode.style.height = '300px';
            vibration.options.legend.position = "bottom";
            // CHARTJS VIBRATION

            // CHARTJS GREASING
            var ctx = document.getElementById('number_of_greasing').getContext('2d');
            var greasing = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: date,
                    datasets: [{
                        data: number_of_greasing,
                        label: "Number of Greasing",
                        borderColor: "rgb(60,176,255)",
                        backgroundColor: "rgb(60,176,255)",
                        fill: false
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                max: 200,
                                stepSize: 50,
                            }
                        }]
                    }
                }
            });
            greasing.canvas.parentNode.style.height = '300px';
            // CHARTJS GREASING

            // HIDDEN NUMBER OF GREASING IF NIPPLE GREASE DOESN'T EXIST
            let html_number_of_greasing = document.getElementById("number_of_greasing");
            if (nipple_grease != "Available") {
                html_number_of_greasing.style.display = "none";
            }

            // HIDDEN FINDINGS LOG IF EMPTY
            const findings = document.getElementById("findings");
            let finding_comments = <?php echo json_encode($comments) ?>;
            if (finding_comments.length == 0) {
                findings.style.display = "none";
            }
        </script>
</body>

</html>