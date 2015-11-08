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
    </div>
  </div>
</div>
<?php get_footer() ?>

<script src="//www.google.com/jsapi"></script>
<script>
  function htmlDecode(input){
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
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
  }

</script>
