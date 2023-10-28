<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

<body>

    @include("utility.navbar")

    <p class="d-none" id="emo">{{ $emo }}</p>

    <div class="container-xl py-5">
        <div class="text-center">
            <h4>Temperature of {{ $emo }}</h4>
            <div class="chart-container" style="position: relative;">
                <canvas id="temperature"></canvas>
            </div>
            <div class="row mt-2 mb-5">
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

        <div style="display: none;" id="number_of_greasing_display" class="mt-3 text-center">
            <h4>Number of Greasing {{ $emo }}</h4>
            <div class="chart-container" style="position: relative;">
                <canvas id="number_of_greasing"></canvas>
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
                    borderColor: "rgb(60,186,159)",
                    backgroundColor: "rgb(60,186,159)",
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
                    borderColor: "rgb(196,88,180)",
                    backgroundColor: "rgb(196,88,180)",
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
                            max: 5,
                            min: -5,
                            stepSize: 1
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
    </script>
</body>

</html>