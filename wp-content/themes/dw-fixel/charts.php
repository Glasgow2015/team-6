<?php /* Template Name: Charts */ ?>
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
      <div id="chart1"></div>
      <div id="chart2"></div>
      <div id="chart3"></div>
      <div id="chart4"></div>
    </div>
  </div>
</div>
<?php get_footer() ?>

<script src="//www.google.com/jsapi"></script>
<script src="<?= get_template_directory_uri() ?>/js/graph3d.js"></script>
<script>
  function htmlDecode(input){
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
  }

  function custom(x, y) {
    return Math.sin(x / 50) * Math.cos(y / 50) * 50 + 50;
  }

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});
      
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);

      
  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {
    jQuery.getJSON('//5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=prevalence', function(data) {
      var prevalence = [];

      for (var i = 0; i < data.length; i++) {
        prevalence.push([htmlDecode(data[i].meta.year_range), parseInt(data[i].meta.affected_people)]);
      }

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows(prevalence);

      // Set chart options
      var options = {
        title: 'Time survived since diagnosis',
        width: 400,
        height: 300
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart1'));
      chart.draw(data, options);
    });

    jQuery.getJSON('//5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=incidents', function (data) {
      var parsedData = [];
      parsedData.push(['Year of Dioagnosis', '1989', '1990', '1991', '1992', '1993', '1994', '1995', '1996', '1997', '1998', '1999', '2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013']);
    
      var meta;
      for (var i = 1; i < data.length; i++) {
        meta = data[i].meta;
        parsedData.push([meta.age_groups]);
        for (var j = 0; j < 25; j++) parsedData[i].push(parseInt(meta[j.toString()]));
      }
    
      var data = google.visualization.arrayToDataTable(parsedData);
      var options = {
        hAxis: {title: 'Age'},
        vAxis: {title: 'Number of patients'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('chart2'));
      chart.draw(data, options);

      // Line chart
      var data = google.visualization.arrayToDataTable(parsedData);

      var options = {
        title: 'Number of patients by age group',
        curveType: 'function',
        legend: { position: 'bottom' }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart3'));
      chart.draw(data, options);
    });

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
      options = {
        width: "400px",
        height: "400px",
        style: "surface",
        showPerspective: true,
        showGrid: true,
        showShadow: false,
        keepAspectRatio: true,
        verticalRatio: 0.5
      };

      // Instantiate our graph object.
      graph = new links.Graph3d(document.getElementById('chart4'));

      // Draw our graph with the created data and options
      graph.draw(data, options);
    }

  }

</script>
