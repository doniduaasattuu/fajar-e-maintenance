<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <div class="container py-4">
        <!-- BAR -->
        <h4 class="text-secondary mb-2">Utility</h4>
        <div class="wrapper row mb-4 px-2">
            <div class="progress-wrapper col-md card shadow-sm rounded py-3 mb-3 mb-md-0">
                <!-- COMPRESSOR -->
                <div class="mb-3">
                    <div class="d-flex text-secondary justify-content-between">
                        <span>Air compressor</span>
                        <span id="compressor_percent"></span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-animated bg-primary" id="compressor"></div>
                    </div>
                </div>
                <!-- COMPRESSOR -->

                <!-- WATER -->
                <div class="mb-2">
                    <div class="d-flex text-secondary justify-content-between">
                        <span>Water level</span>
                        <span id="water_percent"></span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-animated bg-success" id="water"></div>
                    </div>
                </div>
                <!-- WATER -->
            </div>

            <div class="bar-wrapper col-md ms-md-3 card shadow-sm rounded py-3">
                <!-- POWER -->
                <div class="mb-3">
                    <div class="d-flex text-secondary justify-content-between">
                        <span>PM Power Consumption</span>
                        <span id="power_percent"></span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="5000">
                        <div class="progress-bar progress-bar-animated bg-danger" id="power"></div>
                    </div>
                </div>
                <!-- POWER -->

                <!-- WWT -->
                <div class="mb-2">
                    <div class="d-flex text-secondary justify-content-between">
                        <span>WT level</span>
                        <span id="wwt_percent"></span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-animated bg-secondary" id="wwt"></div>
                    </div>
                </div>
                <!-- WWT -->
            </div>
        </div>
        <!-- BAR -->

        <!-- CHART -->
        <h4 class="text-secondary mb-3">Motor</h4>
        <div class="row">
            <div class="col-md">
                <div class="">
                    <div class="alert alert-success text-secondary d-flex justify-content-between" role="alert">
                        <div class="d-block">Status</div>
                        <div>Running</div>
                    </div>
                    <div class="alert alert-success text-secondary d-flex justify-content-between" role="alert">
                        <div class="d-block">Running hours</div>
                        <div>12 Days</div>
                    </div>

                    <div>
                        <!-- GOOGLE -->
                        <div class="justify-content-center d-flex" id="chart_div" style="height: 120px;"></div>
                        <!-- GOOGLE -->
                    </div>

                </div>
            </div>
            <div class="col-md mt-3">
                <canvas id="voltage"></canvas>
            </div>
        </div>
        <script>
            // setTimeout(function() {
            //     chart_div.childNodes[0].style.width = "100%";
            // }, 1000);
            let voltage_data = [395, 410, 397];
            var ctx = document.getElementById('voltage').getContext('2d');
            var voltage = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["R", "S", "T"],
                    datasets: [{
                        data: voltage_data,
                        label: "Voltage",
                        backgroundColor: [
                            "rgb(57, 62, 65)",
                            "rgb(1, 111, 185)",
                            "rgb(163, 186, 195)",
                        ],
                        fill: false
                    }, ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: 500,
                                stepSize: 100,
                                callback: function(value, index, ticks) {
                                    return value + " V";
                                }
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Voltage',
                            },
                            barPercentage: 0.4
                        }]
                    }
                }
            });
            voltage.options.legend.display = false;
            voltage.canvas.parentNode.style.height = '300px';
        </script>
        <!-- CHART -->

        <!-- GOOGLE -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            google.charts.load('current', {
                'packages': ['gauge']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Current R', 70],
                    ['Current S', 70],
                    ['Current T', 70],
                ]);

                var options = {
                    width: 400,
                    height: 120,
                    redFrom: 90,
                    redTo: 100,
                    yellowFrom: 75,
                    yellowTo: 90,
                    minorTicks: 5
                };

                var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

                chart.draw(data, options);

                setInterval(function() {
                    data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
                    chart.draw(data, options);
                }, 100);
                setInterval(function() {
                    data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
                    chart.draw(data, options);
                }, 100);
                setInterval(function() {
                    data.setValue(2, 1, 40 + Math.round(60 * Math.random()));
                    chart.draw(data, options);
                }, 100);
            }
        </script>
        <!-- GOOGLE -->

    </div>


    <script>
        compressor = document.getElementById("compressor");
        water = document.getElementById("water");
        power = document.getElementById("power");
        wwt = document.getElementById("wwt");

        setInterval(function() {
            const comp = Math.floor(Math.random() * 6) + 3
            let compressor_value = `${60 + comp}`
            compressor.style.width = compressor_value + "%";
            compressor_percent = document.getElementById("compressor_percent");
            compressor_percent.textContent = compressor_value + " psi";

            const wtr = Math.floor(Math.random() * 5) + 3
            let water_value = `${70 + wtr}`
            water.style.width = water_value + "%";
            water_percent = document.getElementById("water_percent");
            water_percent.textContent = water_value + " %";

            const pwr = Math.floor(Math.random() * 4) + 3
            let power_value = `${40 + pwr}`
            power.style.width = power_value + "%";
            power_percent = document.getElementById("power_percent");
            power_percent.textContent = (power_value + (pwr + 31)) + " kWh";

        }, 100);

        setInterval(function() {
            const wt = Math.floor(Math.random() * 3) + 1
            let wwt_value = `${80 + wt}`
            wwt.style.width = wwt_value + "%";
            wwt_percent = document.getElementById("wwt_percent");
            wwt_percent.textContent = wwt_value + " %";
        }, 100);
    </script>
</body>

</html>