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
                <img class="img-fluid" src="/images/left-side.jpeg" alt="Left Side">
            </div>
            <div class="col-md">
                <img class="img-fluid" src="/images/front-side.jpeg" alt="Front Side">
            </div>
        </div>

        <div class="mt-5" id="vibration"></div>
        <div class="row">
            <div class="col-md">
                <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Front Side">
            </div>
        </div>
        <div class="mt-5" id="number_of_greasing"></div>
    </div>

    <script src=" https://code.highcharts.com/10/highcharts.js"></script>

    <script>
        // TEMPERATURE
        let temp_a = @json($temperature_a);
        let temp_b = @json($temperature_b);
        let temp_c = @json($temperature_c);
        let temp_d = @json($temperature_d);
        let date = @json($date_category);
        let emo = document.getElementById("emo").textContent;

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('temperature', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: '<b>Temperature of ' + emo + '</b>'
                },
                subtitle: {
                    text: 'Temperature record in one month'
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
        let vibration_value_de = @json($vibration_value_de);
        let vibration_value_nde = @json($vibration_value_nde);

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('vibration', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: '<b>Vibration of ' + emo + '</b>'
                },
                subtitle: {
                    text: 'Vibration record in one month'
                },
                yAxis: {
                    title: {
                        text: 'Vibration - mm/s'
                    },
                    min: -3,
                    max: 3
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
        let number_of_greasing = @json($number_of_greasing);

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('number_of_greasing', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: '<b>Number of greasing ' + emo + '</b>'
                },
                subtitle: {
                    text: 'Greasing record in one month'
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
    </script>
</body>

</html>