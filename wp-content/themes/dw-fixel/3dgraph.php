<?php /* Template Name: 3D Graph */ ?>
<?php get_header() ?>
<div class="headline">
  <div class="headline-wrap">
    <header class="entry-header">
      <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>
  </div>
</div>
<div id="main" role="main">
  <div class="single-page row-fluid">
    <div class="main-content span12">
      <div style="margin: 0 auto; width: 100%; max-width: 800px" id="chart"></div>
    </div>
  </div>
</div>
<?php get_footer() ?>

<script src="//www.google.com/jsapi"></script>
<script src="<?= get_template_directory_uri() ?>/js/graph3d.js"></script>
<script>
  function htmlDecode(input) {
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
  }

  function custom(x, y) {
    return Math.sin(x / 50) * Math.cos(y / 50) * 50 + 50;
  }

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0');
      
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);

      
  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {
    var data = null;
    var graph = null;
    drawVisualization();

    // Called when the Visualization API is loaded.
    function drawVisualization() {
      // Create and populate a data table.
      data = new google.visualization.DataTable();
      data.addColumn('number', 'Year of diagnosis');
      data.addColumn('number', 'Age group');
      data.addColumn('number', 'Number of people');

      var steps = 2014;  // number of datapoints will be steps*steps
      var axisMax = 2014;
      axisStep = axisMax / steps;

      var stepsY = 9;
      var axisYMax = 90;
      var axisStepY = axisYMax / stepsY;

      for (var x = 1989; x < axisMax; x += axisStep) {
        for (var y = 0; y < axisYMax; y += axisStepY) {
          var value = custom(x, y);
          data.addRow([x, 90 - y, value]);
        }
      }

      // specify options
      var options = {
        width: "100%",
        height: "800px",
        style: "surface",
        showPerspective: true,
        showGrid: true,
        showShadow: false,
        keepAspectRatio: true,
        backgroundColor: 'transparent',
        verticalRatio: 0.5
      };

      // Instantiate our graph object.
      graph = new links.Graph3d(document.getElementById('chart'));

      // Draw our graph with the created data and options
      graph.draw(data, options);
    }

  }

</script>
