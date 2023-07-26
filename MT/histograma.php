<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dinosaur', 'Length']
        
          <?php
            for ($i = 0; $i < count($rawdata); $i++) {
              $unixtime_v2 = $rawdata[$i]["unixtime"] * 1000;
              echo ",['" . $unixtime_v2 . "','" . $rawdata[$i]["pot_III"] . "']";
            }
            ?>

        ]);

          var options = {
                            title: 'Approximating Normal Distribution',
                            legend: { position: 'none' },
                            colors: ['#4285F4'],

                            chartArea: { width: 800 },

                            bar: { gap: 0 },

                            histogram: {
                            bucketSize: 0.01,
                            lastBucketPercentile: 5,
                            maxNumBuckets: 400,

                            }
                            

                        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>