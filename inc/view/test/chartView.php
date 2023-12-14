<?php
  $data = "14,19,3,5,2,3,10";
  $labels = "Red,Blue,Yellow,Green,Purple,Orange,Pink"
?>

<input type="hidden" name="data" id="data" value="<?=$data?>">
<input type="hidden" name="labels" id="labels" value="<?=$labels?>">

<div style="width: 500px;">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<form action="">
  <button>Back button</button>
</form>

<script>
  const ctx = document.getElementById('myChart');
  
  let rawData = document.getElementById('data').value;
  let data = rawData.split(",");

  let rawLabels = document.getElementById('labels').value;
  let labels = rawLabels.split(",");


  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: '# of Votes',
        data: data,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>