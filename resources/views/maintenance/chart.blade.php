<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>
    @include("utility.navbar")

    <div class="container">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const DATA_COUNT = 7;
        const NUMBER_CFG = {
            count: DATA_COUNT,
            min: 0,
            max: 100
        };

        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
        const data = {
            labels: labels,
            datasets: [{
                    label: 'Dataset 1',
                    data: [10, 30, 50, 20, 25, 44, -10],
                    borderColor: "rgb(255, 0, 255)",
                    backgroundColor: "rgb(255, 0, 255)",
                },
                {
                    label: 'Dataset 2',
                    data: ['ON', 'ON', 'OFF', 'ON', 'OFF', 'OFF', 'ON'],
                    borderColor: "rgb(0, 0, 255)",
                    backgroundColor: "rgb(0, 0, 255)",
                    stepped: true,
                    yAxisID: 'y2',
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Stacked scales',
                    },
                },
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 2,
                        border: {
                            color: "rgb(255, 255, 0)"
                        }
                    },
                    y2: {
                        type: 'category',
                        labels: ['ON', 'OFF'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        border: {
                            color: "rgb(0, 255, 255)"
                        }
                    }
                }
            },
        };

        // CHARTJS MOTOR STATUS
        var ctxm = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctxm, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Stacked scales',
                    },
                },
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 2,
                        border: {
                            color: "rgb(255, 255, 0)"
                        }
                    },
                    y2: {
                        type: 'category',
                        labels: ['ON', 'OFF'],
                        offset: true,
                        position: 'left',
                        stack: 'demo',
                        stackWeight: 1,
                        border: {
                            color: "rgb(0, 255, 255)"
                        }
                    }
                }
            },
        });
    </script>
</body>

</html>