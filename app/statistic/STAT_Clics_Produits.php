<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$year_from = $_GET['YF'];
$year_to = $_GET['YT'];
$month_from = $_GET['MF'];
$month_to = $_GET['MT'];
$graph_type = $_GET['GT'];

    $sql = "SELECT A.name_fr AS product_fr, A.qty_visited, B.name_fr AS category_name FROM product A 
    LEFT JOIN product_category B ON A.category_id = B.id
    WHERE A.qty_visited > 1;";
    
    $result = mysqli_query($dw3_conn, $sql);
    $numResults = $result->num_rows;
    $counter = 0;
    $var_label = "";
    $var_data = "";
    date_default_timezone_set('America/New_York');
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $var_label .= "'".$row["product_fr"]." (". $row["category_name"] .")'";
            $var_data .= $row["qty_visited"];
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

  <div style='width:100%;max-width:100%;overflow:scroll;height:90vh;'><canvas id="myChart" style='width:100%;height:100%;background-color:rgba(255,255,255,0.9);'></canvas></div>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: '<?php echo $graph_type; ?>',
    data: {
      labels: [<?php echo $var_label; ?>],
      datasets: [{
        label: 'Nombre de clics sur les produits (>1)',
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
                        //return '$' + value;
                        return value;
                    }
                }
            }
        },
       
      plugins: {
        tooltip: {
            callbacks: {
            label: function(context) {
/*                 let label = context.dataset.label || '';

                if (label) {
                label += ': ' + context.parsed.y;
                } */
/*                 if (context.parsed.y !== null) {
                label += new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(context.parsed.y);
                } */
                return " "+context.parsed.y;
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
