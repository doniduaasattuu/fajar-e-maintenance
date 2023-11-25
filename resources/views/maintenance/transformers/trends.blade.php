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
            <h4 class="text-break">Primary Current of {{ $sort_field }}</h4>

            <div class="chart-container" style="position: relative;">
                <canvas id="primary_current"></canvas>
            </div>

            <div class="mt-3 text-center">
                <div>
                    <h4 class="text-break">Vibration DE of {{ $sort_field }}</h4>
                    <div class="chart-container" style="position: relative;">
                        <canvas id="vibration_de"></canvas>
                    </div>
                </div>
                <div class="my-3">
                    <h4 class="mt-5 text-break">Vibration NDE of {{ $sort_field }}</h4>
                    <div class="chart-container" style="position: relative;">
                        <canvas id="vibration_nde"></canvas>
                    </div>
                </div>

            </div>

            <script>
                let date = <?php echo json_encode($date_category) ?>;
                let primary_current_phase_r = <?php echo json_encode($primary_current_phase_r) ?>;
                let primary_current_phase_s = <?php echo json_encode($primary_current_phase_s) ?>;
                let primary_current_phase_t = <?php echo json_encode($primary_current_phase_t) ?>;

                let secondary_current_phase_r = <?php echo json_encode($secondary_current_phase_r) ?>;
                let secondary_current_phase_s = <?php echo json_encode($secondary_current_phase_s) ?>;
                let secondary_current_phase_t = <?php echo json_encode($secondary_current_phase_t) ?>;

                const footer = (tooltipItems) => {
                    return 'By: ' + checked_by[tooltipItems[0].dataIndex];
                };

                // CHARTJS VIBRATION AND NOISE DE
                var ctxvde = document.getElementById('primary_current').getContext('2d');
                var primary_current = new Chart(ctxvde, {
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
                                    text: 'mm/s',
                                },
                            },
                        },
                    }
                });
                primary_current.canvas.parentNode.style.height = '300px';
                primary_current.options.plugins.legend.position = "bottom";
                // CHARTJS VIBRATION DE
            </script>
</body>

</html>