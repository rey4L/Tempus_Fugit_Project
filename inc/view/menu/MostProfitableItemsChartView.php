<?php
    include __DIR__."/../NavbarView.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS_URL."graph-view.css"?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Sales Chart</title>
</head>

<body>
    <input type="hidden" name="data" id="data" value="<?=$data['data']?>">
    <input type="hidden" name="labels" id="labels" value="<?=$data['labels']?>">

    <div class="graph-div">
        <canvas id="myChart"></canvas>
    </div>

    <form class="back-to-register-form" action="">
        <button class="graph-back-button">Back to Register</button>
    </form>

    <script>
        const ctx = document.getElementById('myChart');
        
        let rawData = document.getElementById('data').value;
        let data = rawData.split(",");

        let rawLabels = document.getElementById('labels').value;
        console.log(rawLabels);
        let labels = rawLabels.split(",");

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit Generated',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0  
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>