<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Chart Test</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <h1>Chart Test</h1>
    <div id="test-chart" style="max-width: 600px; margin: 35px auto;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Sales',
                    data: [30, 40, 45, 50, 49, 60, 70, 91]
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
                }
            };
            var chart = new ApexCharts(document.querySelector("#test-chart"), options);
            chart.render();
        });
    </script>
</body>
</html>
