<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <p class="d-none" id="emo">{{ $emo }}</p>

    <div class="container-xl py-4">
        <div id="temperature"></div>
        <div class="row mb-5">
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

        <div class="mt-5" id="vibration"></div>
        <div class="row">
            <div class="col-md">
                <figure>
                    <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Vibration">
                    <figcaption class="figure-caption text-center">Vibration standard</figcaption>
                </figure>
            </div>
        </div>
        <div class="mt-5" id="number_of_greasing"></div>
    </div>

    <script src=" https://code.highcharts.com/10/highcharts.js"></script>

    <script>
        // TEMPERATURE
        let temp_a = <?php echo json_encode($temperature_a) ?>;
        let temp_b = <?php echo json_encode($temperature_b) ?>;
        let temp_c = <?php echo json_encode($temperature_c) ?>;
        let temp_d = <?php echo json_encode($temperature_d) ?>;
        let date = <?php echo json_encode($date_category) ?>;
        let emo = document.getElementById("emo").textContent;
        let nipple_grease = "<?php echo $nipple_grease ?>"

        if (temp_a.length < 4) {
            chart_type = "column"
        } else {
            chart_type = "spline"
        }

        function subText(data) {
            return data + " record over a certain period of time";
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('temperature', {
                chart: {
                    type: chart_type
                },
                title: {
                    text: '<b>Temperature of ' + emo + '</b>'
                },
                subtitle: {
                    text: subText("Temperature")
                },
                yAxis: {
                    title: {
                        text: 'Degree Celcius - °C',
                    },
                    min: 0,
                    max: 150
                },
                xAxis: {
                    categories: date
                },
                series: [{
                    name: "Point A",
                    data: temp_a
                }, {
                    name: "Point B",
                    data: temp_b
                }, {
                    name: "Point C",
                    data: temp_c
                }, {
                    name: "Point D",
                    data: temp_d
                }]
            });
        });

        // VIBRATION
        let vibration_value_de = <?php echo json_encode($vibration_value_de) ?>;
        let vibration_value_nde = <?php echo json_encode($vibration_value_nde) ?>;

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('vibration', {
                chart: {
                    type: chart_type
                },
                title: {
                    text: '<b>Vibration of ' + emo + '</b>'
                },
                subtitle: {
                    text: subText("Vibration")
                },
                yAxis: {
                    title: {
                        text: 'Vibration - mm/s'
                    },
                    min: -5,
                    max: 5
                },
                xAxis: {
                    categories: date
                },
                series: [{
                    name: "Vibration DE",
                    data: vibration_value_de
                }, {
                    name: "Vibration NDE",
                    data: vibration_value_nde
                }]
            });
        });

        // NUMBER OF GREASING
        let number_of_greasing = <?php echo json_encode($number_of_greasing) ?>

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('number_of_greasing', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<b>Number of greasing ' + emo + '</b>'
                },
                subtitle: {
                    text: subText("Greasing")
                },
                yAxis: {
                    title: {
                        text: 'Time'
                    },
                },
                xAxis: {
                    categories: date
                },
                series: [{
                    name: "Number of Greasing",
                    data: number_of_greasing
                }]
            });
        });

        // HIDDEN NUMBER OF GREASING IF NIPPLE GREASE DOESN'T EXIST
        let html_number_of_greasing = document.getElementById("number_of_greasing");
        if (nipple_grease != "Available") {
            html_number_of_greasing.style.display = "none";
        }
    </script>
</body>

</html>