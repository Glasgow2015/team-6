<?php /* Template Name: Map */ ?>
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
      <div id="map" style="height: 600px; width: 100%"></div>
    </div>
  </div>
</div>
<?php get_footer() ?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyC1Fuqax5sLGDq4KRkjaTobvhq-y-UyNVA"></script>
<script>
  var imageSup = '<?= get_template_directory_uri(); ?>/img/iconSup3.png';
  var imagePat = '<?= get_template_directory_uri(); ?>/img/iconPat4.png';
    
  var patients = [];
  var supps= [];
    
  function onCooRecieved2() {
    var network = [];
    
    for (var i = 0; i < patients.length; i++) {
      network.push({patient: patients[i], support: []});
        
      for (var j = 0; j < supps.length; j++) {
        if (patients[i].name == supps[j].pat) {
          network[i].support.push(supps[j]);
        }
      }
    }
    
    var Glasgow = {lat: 55.852749, lng: -4.2209248};
    var map = new google.maps.Map(document.getElementById('map'), {
      center: Glasgow,
      zoom: 12
    });

    for (var i = 0; i < network.length; i++) {
      var p = network[i].patient;
      var source = p.code;

      var contentString = '<img src='
        + (p.picture || '//1.gravatar.com/avatar/a77e89a55fbb1d4852877c833c158edd?s=32&d=mm&r=g')
        + '> '
        + (p.name || '')
        + '<br>'
        + (p.email || '');
      var infoWindow = new google.maps.InfoWindow({content: contentString});
    
      var marker = new google.maps.Marker({
        position: source,
        map: map,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        icon: imagePat
      });

      marker.addListener('click', function(marker, infoWindow) {
        infoWindow.open(map, marker);
      }.bind(this, marker, infoWindow));
      
      var supporters = network[i].support;
      for (var j = 0; j < supporters.length; j++) {
        var s = supporters[j];
        contentString = '<img src='
          + (s.picture || '//1.gravatar.com/avatar/a77e89a55fbb1d4852877c833c158edd?s=32&d=mm&r=g')
          + '> '
          + (s.name || '')
          + '<br>'
          + (s.email || '');
        infoWindow = new google.maps.InfoWindow({content: contentString});

        var marker = new google.maps.Marker({
          position: supporters[j].code,
          map: map,
          mapTypeId: google.maps.MapTypeId.TERRAIN,
          icon: imageSup
        });

        marker.addListener('click', function(marker, infoWindow) {
          infoWindow.open(map, marker);
        }.bind(this, marker, infoWindow));

        var paths = [supporters[j].code, source];
        var flightPath = new google.maps.Polyline({
          path: paths,
          geodesic: true,
          strokeColor: '#855081',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });
        
        flightPath.setMap(map);
      }
    }      
  }
    
  function onCooRecieved(){
    var m = supps.length;
    for (var i = 0; i < supps.length; i++) {
      var supp = supps[i];
      supps[i] = {
        name: supp.title,
        code: supp.meta.post_code,
        pat: supp.meta.member.post_title,
        interests: supp.meta.interests,
        picture: supp.meta.picture,
        email: supp.meta.email
      };
      var apiUrl = "http://maps.googleapis.com/maps/api/geocode/json?address=" + supps[i].code + "&sensor=false";
      jQuery.getJSON( apiUrl, function(i, data) {
        m--;
        supps[i].code = data.results[0].geometry.location;
        if (m == 0) onCooRecieved2();
      }.bind(this, i));
            
    }                                     
  }
    
  function onDataRecieved() {
    var l = patients.length;
    for (var i = 0; i < patients.length; i++) {
      var patient = patients[i];
      patients[i] = {
        name: patient.title,
        code: patient.meta.post_code,
        interests: patient.meta.interests,
        picture: patient.meta.picture,
        email: patient.meta.email
      };
      var apiUrl = "http://maps.googleapis.com/maps/api/geocode/json?address=" + patients[i].code + "&sensor=false";
      jQuery.getJSON( apiUrl, function( i, data ) {
        l--;
        patients[i].code = data.results[0].geometry.location;
        if (l == 0) onCooRecieved();
      }.bind(this, i));
    }     
  }

  jQuery.getJSON( "http://5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=member", function(data) {
    patients = data;
    jQuery.getJSON( "http://5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=supporter", function(data) {
      supps = data;
      onDataRecieved();
    });
  });

</script>
