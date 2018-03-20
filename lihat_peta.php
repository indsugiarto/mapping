<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SiPus Musaga</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <!-- <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <!-- <link href="../vendor/morrisjs/morris.css" rel="stylesheet"> -->

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    <link rel="stylesheet" type="text/css" href="../../lib/leaflet/leaflet.css">
    <link rel="stylesheet" type="text/css" href="../../lib/leaflet/leaflet.iconlabel.css">
    <script type="text/javascript" src="../../lib/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="../../lib/leaflet/leaflet.iconlabel.js"></script>
    <script type="text/javascript" src="../../data/Kec_Purbalingga.geojson"></script>
    <script type="text/javascript" src="../../data/desa_purbalingga.geojson"></script>
    <style type="text/css">
      #map{height: 485px;}
      .legend { background : white; line-height : 1.5em}
      .legend i { width : 2em; float : left }
      .info {
          padding: 6px 8px;
          font: 14px/16px Arial, Helvetica, sans-serif;
          background: white;
          background: rgba(255,255,255,0.8);
          box-shadow: 0 0 15px rgba(0,0,0,0.2);
          border-radius: 5px;
      }
      .info h4 {
          margin: 0 0 5px;
          color: #777;
      }
      .map-label { background : yellow }
      .countryLabel{
        background: rgba(255, 255, 255, 0);
        border:0;
        border-radius:0px;
        width: fixed;
        font-family: sans-serif;
        font-size: 12px;
        color: #666;
        position:absolute;
        box-shadow: 0 0px 0px;
        
      }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php

  include "../../includes/config/koneksi.php";
  $prosentase=0.065;
?>
    <div id="wrapper">
        <div >
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Peta Persebaran DBD</h1>
                </div>
                <!-- wara #5fce1a #b2ff00 #dfff6d #cef444 #dbff5b  sedag #ffd016 #ffcb00  #ffc300
                /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div id="map"></div> 
                       <script>
                          function getCountryColor(prosentase){
                              if(prosentase==0){
                                return '#3fd624';
                              }
                              else if(prosentase<0.02){
                                return '#b2ff00';
                              }
                              else if(prosentase>0.055){
                                return '#FC4E2A';
                              }
                              else{
                                return '#ff8800';
                              }
                          }
                          function getdesaColor(prosentase){
                              if(prosentase==0){
                                return '#3fd624';
                              }
                              else if(prosentase<0.02){
                                return '#b2ff00';
                              }
                              else if(prosentase>0.055){
                                return '#FC4E2A';
                              }
                              else{
                                return '#ff8800';
                              }
                          }
                          function countriesStyle(feature){
                            return{
                              fillColor:getCountryColor(feature.properties.prosentase),
                              weight:2,
                              opacity:1,
                              color:'white',
                              dashArray:3,
                              fillOpacity:0.7
                            }
                          }
                          function desaStyle(feature){
                            return{
                              fillColor:getdesaColor(feature.properties.prosentase),
                              weight:2,
                              opacity:1,
                              color:'white',
                              dashArray:3,
                              fillOpacity:0.7
                            }
                          }
                          var map = L.map('map', {
                            scrollWheelZoom: true,
                            dragging: true,
                            doubleClickZoom: false,
                            center: [43.8476, 18.3564],
                            zoom: 13,
                            maxZoom: 15,
                            minZoom: 10,
                            zoomControl: true,
                            attributionControl: false,
                        });

                          //var map=L.map('map').setView([43.8476, 18.3564], 13);
                          //var countriesLayer=L.geoJson(countries,{style:countriesStyle}).addTo(map);
                          //map.fitBounds(countriesLayer.getBounds());
                          // function highlightFeature(e) {
                          //   var layer = e.target;
                          //   layer.setStyle({
                          //       weight: 5,
                          //       color: '#ccc',
                          //       dashArray: '',
                          //       fillOpacity: 0.7
                          //   });
                          //   if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge)
                          //   {
                          //       layer.bringToFront();
                          //   }
                          // }
                          var geojson;
                          var desajson;
                          var DesaLayer;
                          // ... our listeners
                          geojson = L.geoJson(countries,{style:countriesStyle});
                          desajson = L.geoJson(desa,{style:desaStyle});
                          
                          // function resetHighlight(e) 
                          // {
                          //   geojson.resetStyle(e.target);
                          // }
                          function zoomToFeature(e) {
                            var layer = e.target;
                            var fitur=layer.feature.properties.WADMKC;
                            map.fitBounds(e.target.getBounds());
                            //L.layerGroup([desajson, geojson]).addTo(map);
                            //var atribut_desa=layer.feature.properties;
                            
                            if (DesaLayer) {
                              map.removeLayer(DesaLayer);
                              DesaLayer.clearLayers();
                            }
                            //map.removeLayer(DesaLayer);
                            //DesaLayer.clearLayers();
                            DesaLayer = L.geoJson(desa, {style: desaStyle,
                              filter: layerFilter}).addTo(map);
                            //DesaLayer.clearLayers();
                            //map.removeLayer(DesaLayer);
                            //polyLayer will only include features for which this function returns true
                            function layerFilter(feature) {
                              //var nama_kec=fitur.properties.WADMKC;
                              if (feature.properties.WADMKC === fitur) return true;
                            }
                          }

                                      // var markers= new Array();

                          function onEachFeature(feature, layer) {
                            // layer.bindLabel(feature.properties.penderita.toString(), {noHide:true, direction: 'auto'});
                            // var countriesLayer1=L.geoJson(countries,{style:countriesStyle})
                                    //   markers.push(
                                    //   L.circleMarker(
                                    //     layer.getBounds().getCenter(),
                                    //     {
                                    //       radius : 0.0,
                                    //       opacity : 0,
                                    //       fillOpacity : 0
                                    //     }
                                    //   )
                                    // );
                                    // var markersCount=markers.lenght;
                                    // markers[markersCount-1].bindLabel(
                                    //   feature.properties.WADMKC.toString(),
                                    //   {
                                    //       noHide : true,
                                    //       className : 'map-label',
                                    //       pane : 'mapPane'
                                    //   }
                                    // );

                                    // markers[markersCount - 1].addTo(map);
                                    // //markers[markersCount - 1].hideLabel();

                            layer.on({
                                mouseover: highlightFeature,
                                mouseout: resetHighlight,
                                click: zoomToFeature
                            });
                            layer.bindTooltip(feature.properties.WADMKC, {
                              permanent:true,
                              direction:'center',
                              className: 'countryLabel'}); 
                          }
                          geojson = L.geoJson(countries, {
                            style: countriesStyle,
                            onEachFeature: onEachFeature
                          }).addTo(map);
                          map.fitBounds(geojson.getBounds());
                          var info = L.control();
                          info.onAdd = function (map) {
                            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
                            this.update();
                            return this._div;
                          };
                          // method that we will use to update the control based on feature properties passed
                          info.update = function (countries) {
                            this._div.innerHTML = '<h4>Jumlah penderita DBD</h4>' +  (countries ?
                            '<b>' + countries.WADMKC + '</b><br />' + countries.penderita + ' penderita'
                            : 'arahkan pointer ke peta');
                          };
                          info.addTo(map);
                          function highlightFeature(e) {
                            var layer = e.target;
                            layer.setStyle({
                                weight: 5,
                                color: '#666',
                                dashArray: '',
                                fillOpacity: 0.7
                            });
                            info.update(layer.feature.properties);
                          }
                          function resetHighlight(e) {
                             geojson.resetStyle(e.target);
                            info.update();
                          }

                          var legend = L.control({position : 'bottomright'});
                          legend.onAdd = function(map){
                          var div = L.DomUtil.create('div', 'legend');
                          var labels = [
                            "Prosentase penderita 0%",
                            "Prosentase penderita kurang dari 0,02%",
                            "Prosentase penderita antara 0,02% dan 0,055%",
                            "Prosentase penderita lebih dari 0,055%"
                          ];
                          var grades = [0,0.019,0.021,0.056];
                          div.innerHTML = '<div><b>Legenda</b></div>';
                          for(var i = 0; i < grades.length; i++)
                          {
                            div.innerHTML += '<i style="background:' 
                            + getCountryColor(grades[i]) + '">&nbsp;&nbsp;</i>&nbsp;&nbsp;'
                            + labels[i] + '<br />';
                          }
                          return div;
                          }
                          legend.addTo(map);

                          // map.on(
                          //     'zoomend',
                          //     function(e){
                          //       if(map.getZoom()>12){
                          //         desajson = L.geoJson(desa, {
                          //         style: desaStyle,
                          //         onEachFeature: onEachFeature
                          //         }).addTo(map);
                          //         map.fitBounds(desajson.getBounds());
                          //       }
                          //       else{
                          //         geojson = L.geoJson(countries, {
                          //         style: countriesStyle,
                          //         onEachFeature: onEachFeature
                          //         }).addTo(map);
                          //         map.fitBounds(geojson.getBounds());
                          //       }
                          //     }
                          //   );
                          // var visible;
                          // map.on(
                          //     'zoomend',
                          //     function(e){
                          //       if(map.getZoom()>5)
                          //       {
                          //         if(!visible){
                          //           for(int=0;i<markerslenght; i++){
                          //             markers[i].showLabel();
                          //           }
                          //           visible=true;
                          //         }
                          //       }
                          //       else
                          //       {
                          //         if(visible){
                          //           for(var i=0;i<markers.lenght;i++){
                          //             markers[i].hideLabel()
                          //           }
                          //         }
                          //       }
                          //     }
                          //   )
                          // //var map = L.map('map');
                          // map.createPane('labels');
                          // map.getPane('labels').style.zIndex = 650;
                          // map.getPane('labels').style.pointerEvents = 'none';
                          // var positron = L.tileLayer('countries').addTo(map);
                          // var positronLabels = L.tileLayer('countries', {
                          //     pane: 'labels'}).addTo(map);
                          // // var geojsons = L.geoJson(countries,{style:countriesStyle}).addTo(map);
                          // geojson.eachLayer(function (layer) {
                          //   layer.bindPopup(layer.feature.properties.WADMKC);
                          // });

                          map.fitBounds(geojson.getBounds());
                        </script>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6"></div>
                                  
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <!-- <script  src="../vendor/jquery/jquery.js"></script> -->
    
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <!-- <script src="../vendor/jquery.min.js"></script> -->
   <!--  <script  src="../vendor/jquery/jquery.js"></script> -->
    <!-- <link href="../select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="../select2/dist/js/select2.min.js"></script> -->
    <link href="../../dist/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="../../dist/select2/dist/js/select2.min.js"></script>
    <!--<script src="../vendor/bootstrap/js/try.js"></script>-->
    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="../../dist/js/sb-admin-2.js"></script>
</body>

</html>
