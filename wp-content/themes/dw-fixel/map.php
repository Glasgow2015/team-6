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
        
        function onCooRecieved2(){
        
        network = [];
        
        for(var i = 0; i<patients.length; i++){
            network.push({patient: patients[i].code, support: [] });
            
            for(var j = 0; j<supps.length; j++){
                if(patients[i].name == supps[j].pat){
                    network[i].support.push(supps[j].code);
                }
            }
        }
        
            
            var Glasgow = {lat: 55.852749, lng: -4.2209248};
    
            var map = new google.maps.Map(document.getElementById('map'), {
                center: Glasgow,
                zoom: 12
            });
        
        
        
            for(var i = 0; i<network.length; i++){
            
                var source = network[i].patient;
            
                var marker = new google.maps.Marker({
                    position: source,
                    map: map,
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    icon: imagePat
                });
            
            
                var supporters = network[i].support;
                
                for(var j = 0; j<supporters.length; j++){
                
                    
                
                    var marker = new google.maps.Marker({
                        position: supporters[j],
                        map: map,
                        mapTypeId: google.maps.MapTypeId.TERRAIN,
                        icon: imageSup
                    });
                    
                   
                    
                    var paths = [supporters[j], source];
                
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
            for(var i = 0; i<supps.length; i++){

                supps[i] = {name: supps[i].title, code: supps[i].meta.post_code, pat: supps[i].meta.member.post_title};
                
                var apiUrl = "http://maps.googleapis.com/maps/api/geocode/json?address=" + supps[i].code + "&sensor=false";
                jQuery.getJSON( apiUrl, function( i, data ) {
                    m--;
                    supps[i].code = data.results[0].geometry.location;
                    if(m == 0){
                        onCooRecieved2();
                    }
                }.bind(this, i));
                
            }                                     
        }
        
        
        function onDataRecieved(){
            
            var l = patients.length;
            
            for(var i = 0; i<patients.length; i++){
            
                patients[i] = {name: patients[i].title, code: patients[i].meta.post_code};
                
                var apiUrl = "http://maps.googleapis.com/maps/api/geocode/json?address=" + patients[i].code + "&sensor=false";
                jQuery.getJSON( apiUrl, function( i, data ) {
                    l--;
                    patients[i].code = data.results[0].geometry.location;
                    if(l == 0){
                        onCooRecieved();
                    }
                }.bind(this, i));
                
                       
            }     
        }
        
        
     
     
            
     jQuery.getJSON( "http://5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=member", function( data ) {
        patients = data;
            
        jQuery.getJSON( "http://5c1223b5.ngrok.com/cancer/team-6/wp-json/posts?type=supporter", function( data ) {
            supps = data;
                
            onDataRecieved();
                
        });
            
    });
    
       

    </script>