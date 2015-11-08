<?php /* Template Name: Frequency */ ?>
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
      <div id="chart2"></div><br><br>
      <div id="chart3"></div>
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
        backgroundColor: 'transparent',
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
        backgroundColor: 'transparent',
        legend: { position: 'bottom' }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart3'));
      chart.draw(data, options);
    });

  }

</script>
