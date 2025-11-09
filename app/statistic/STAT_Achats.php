<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$year_from = $_GET['YF'];
$year_to = $_GET['YT'];
$month_from = $_GET['MF'];
$month_to = $_GET['MT'];
$graph_type = $_GET['GT'];

    $sql = "SELECT year,LPAD(period,2,0) AS period, ROUND(SUM(amount),2) as gtot FROM gls 
    WHERE CONCAT(year,LPAD(period,2,0)) >= '" . $year_from .$month_from . "' AND CONCAT(year,LPAD(period,2,0)) <= '" . $year_to .$month_to . "'
    AND gl_code = '1060' AND kind='CREDIT' GROUP BY year,period ORDER BY year,period;";
    
    $result = mysqli_query($dw3_conn, $sql);
    $numResults = $result->num_rows;
    $counter = 0;
    $var_label = "";
    $var_data = "";
    date_default_timezone_set('America/New_York');
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $var_label .= "'".$row["year"]."-".$row["period"]."'";
            $var_data .= $row["gtot"];
            if (++$counter == $numResults) {
            // last row
                    //echo "";
            } else {
            // not last row
                    $var_label .= ",";
                    $var_data .= ",";
            }
        }
    }
?>
<!DOCTYPE html><html lang="fr-CA"><head><meta charset="utf-8">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html,body{
        height:100%;
        margin:0;
        padding:0;
    }
    </style>
</head>
<body>

  <canvas id="myChart" style='width:100%;height:100%;background-color:rgba(255,255,255,0.9);'></canvas>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: '<?php echo $graph_type; ?>',
    data: {
      labels: [<?php echo $var_label; ?>],
      datasets: [{
        label: 'Achats avec taxes par période',
        data: [<?php echo $var_data; ?>],
        borderWidth: 1
      }]
    },
    options: {
        responsive: true,
        <?php if ($graph_type == "line" || $graph_type == "bar"){ ?>
        scales: {
            y: {
            beginAtZero: true,
            ticks: {
                    callback: function(value, index, ticks) {
                        return '$' + value;
                    }
                }
            }
        },
       
      plugins: {
        tooltip: {
            callbacks: {
            label: function(context) {
                let label = context.dataset.label || '';

                if (label) {
                label += ': ';
                }
                if (context.parsed.y !== null) {
                label += new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(context.parsed.y);
                }
                return label;
            }
            }
        }
      }
      <?php } ?>
}
  });
</script>
</body>
</html>
