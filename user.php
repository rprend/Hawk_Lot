<?php
  include "header/header-control.php";
  if($_SESSION['logon']<1) {
    header("refresh:0; url=index.php");
    echo "USER IS NOT LOGGED ON";
    session_destroy();
    exit;
  }
?>

<html>
<head>
  <title>Hawklot Map</title>
  <?php
  if($_SESSION['logon']==1 || $_SESSION['logon']==3) {
      include "/header/header-head.php";
    }
  ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css"></link>
  <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>
  <script src="js/realtime.js"></script>
  <link rel="stylesheet" href="/style/admin.css"></link>

  <style>
  .spotInfo {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white; background: rgba(255,255,255,1);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
  }
  .spotInfo h4 {
     margin: 0 0 5px;
     color: #777;
   }
   .spotInfo p {
      margin: 0 0 4px;
    }

    button.close{
        float:right;
        margin-top:-5px;
        margin-right:-5px;
        cursor:pointer;
        color: #605F61;
        padding-left: 7px;
        padding-top: 0px;
        opacity: .4;
    }

    .leaflet-bar a {
      background-color: #fff;
      border-bottom: 1px solid #ccc;
      color: #444;
      display: block;
      height: 26px;
      width: 26px;
      line-height: 1.45 !important;
      text-align: center;
      text-decoration: none;
      font: bold 18px 'Lucida Console', Monaco, monospace;
     }
     .leaflet-control-layers {
       box-shadow: 0 1px 5px rgba(0,0,0,0.4);
       background: #fff;
       border-radius: 5px;
       }
     .leaflet-control-layers-expanded {
         width: 500px;
         float: left;
     }

  </style>
</head>
<body>
  <?php if($_SESSION['logon']==1 || $_SESSION['logon']==3) : ?>
  <?php if($_SESSION['logon']==1 || $_SESSION['logon']==3) {
      include "/header/header-body.php";
    }
    ?>
    <div id="map"></div>
  <script>
  var jocklot = L.tileLayer('JOCKLOT/{z}/{x}/{y}.png');
  var awing = L.tileLayer('A_Wing_Lot/{z}/{x}/{y}.png');
  var northlot = L.tileLayer('North_Lot/{z}/{x}/{y}.png');

  var map = L.map('map', {
    minZoom: 0,
    maxZoom: 5,
    center: [0, 0],
    zoom: 2,
    layers: [jocklot],
    crs: L.CRS.Simple,
    zoomControl: false
  });

  var baseMaps = {
      "Jock Lot": jocklot,
      "A Wing": awing,
      "North Lot": northlot
  };

  L.Control.zoomHome = L.Control.extend({
      options: {
          position: 'topleft',
          zoomInText: '+',
          zoomInTitle: 'Zoom in',
          zoomOutText: '-',
          zoomOutTitle: 'Zoom out',
          zoomHomeText: '<i class="fa fa-home" style="line-height:1.65;"></i>',
          zoomHomeTitle: 'Zoom home'
      },

      onAdd: function (map) {
          var controlName = 'gin-control-zoom',
              container = L.DomUtil.create('div', controlName + ' leaflet-bar'),
              options = this.options;

          this._zoomInButton = this._createButton(options.zoomInText, options.zoomInTitle,
          controlName + '-in', container, this._zoomIn);
          this._zoomHomeButton = this._createButton(options.zoomHomeText, options.zoomHomeTitle,
          controlName + '-home', container, this._zoomHome);
          this._zoomOutButton = this._createButton(options.zoomOutText, options.zoomOutTitle,
          controlName + '-out', container, this._zoomOut);

          this._updateDisabled();
          map.on('zoomend zoomlevelschange', this._updateDisabled, this);

          return container;
      },

      onRemove: function (map) {
          map.off('zoomend zoomlevelschange', this._updateDisabled, this);
      },

      _zoomIn: function (e) {
          this._map.zoomIn(e.shiftKey ? 3 : 1);
      },

      _zoomOut: function (e) {
          this._map.zoomOut(e.shiftKey ? 3 : 1);
      },

      _zoomHome: function (e) {
          map.setView([0,0], 2);
      },

      _createButton: function (html, title, className, container, fn) {
          var link = L.DomUtil.create('a', className, container);
          link.innerHTML = html;
          link.href = '#';
          link.title = title;

          L.DomEvent.on(link, 'mousedown dblclick', L.DomEvent.stopPropagation)
              .on(link, 'click', L.DomEvent.stop)
              .on(link, 'click', fn, this)
              .on(link, 'click', this._refocusOnMap, this);

          return link;
      },

      _updateDisabled: function () {
          var map = this._map,
              className = 'leaflet-disabled';

          L.DomUtil.removeClass(this._zoomInButton, className);
          L.DomUtil.removeClass(this._zoomOutButton, className);

          if (map._zoom === map.getMinZoom()) {
              L.DomUtil.addClass(this._zoomOutButton, className);
          }
          if (map._zoom === map.getMaxZoom()) {
              L.DomUtil.addClass(this._zoomInButton, className);
          }
      }
  });
  var zoomHome = new L.Control.zoomHome();
  zoomHome.addTo(map);

  L.control.layers(baseMaps, null , {
    collapsed: false,
    position: 'bottomleft'
  }).addTo(map);

  var w = [4608, 8960, 13568],
    h = [3584, 11008, 4352];

  var parking_lot = 'jocklot.json';

  var southWest = map.unproject([0, h[0]], map.getMaxZoom());
  var northEast = map.unproject([w[0], 0], map.getMaxZoom());
  var bounds = new L.LatLngBounds(southWest, northEast);

  map.setMaxBounds(bounds);

  map.on('baselayerchange', function(e) {
    clickListner = false;
    spotInfo.update(null,'');
    if (e.layer == awing) {
      map.options.maxZoom = 6;
      var lot_index = 1;
      parking_lot = 'awing.json';
    }
    if (e.layer == jocklot) {
      map.options.maxZoom = 5;
      var lot_index = 0;
      parking_lot = 'jocklot.json';
    }
    if (e.layer == northlot) {
      map.options.maxZoom = 6;
      var lot_index = 2;
      parking_lot = 'northlot.json';
    }
    realtime.setUrl(parking_lot);

    var southWest = map.unproject([0, h[lot_index]], map.getMaxZoom());
    var northEast = map.unproject([w[lot_index], 0], map.getMaxZoom());
    var bounds = new L.LatLngBounds(southWest, northEast);
    map.setMaxBounds(bounds);
    map.fitBounds(e.layer);
  //  realtime.stop();
  //  realtime.remove(features);

  /*  var jsonChange = new XMLHttpRequest();
    jsonChange.onload = function(){

      jsonChange.update(null,response);
    };
    jsonChange.open("get","update_json.php?lot="+parking_lot, true);
    jsonChange.send();
  */
  });

  var clickListner = false; //true when a spot is selected AND the popup is on its default screen (this value allows/disallows the per-second update of the popup menu)
  var clickLocation = 000; //spot_number selected
  var occupiedAddition = ' ';
  var rentMeButton = '';
  var allow_clicks = true;

  var userReq = new XMLHttpRequest();
  var username_start = "";
  userReq.onload = function() {
    var user_information = this.responseText.split(",");
    username_start = user_information[1];
  }
  userReq.open("get", "get_user_info.php?src=user", true);
  userReq.send();
  var spot_rented = false;
  var spot_rented_num = -2;


  /*function addControlPlaceholders(map) {
    var corners = map._controlCorners,
      l = 'leaflet-',
      container = map._controlContainer;

    function createCorner(vSide, hSide) {
      var className = l + vSide + ' ' + l + hSide;
      corners[vSide + hSide] = L.DomUtil.create('div', className, container);
    }
      createCorner('verticalcenter', 'right');
  }
  addControlPlaceholders(map);
  */

  function rentSpot(id,value){
    var name = '',
        money = '',
        owner = '',
        response = '',
        spot_info = '';
        username = '';
    /*alert('Spot number ' + id.toString() + ' is now ' + (!value).toString());
    var val = !value; //when changing true->false, val will be false, and will be true when false->true
    $.post("json_edit.php",{id: id, value: val});
      return false;*/
    var userReq = new XMLHttpRequest();
    userReq.onload = function() {
      user_info = this.responseText.split("-");
      name = user_info[0];
      money = user_info[2];
      username = user_info[1];
      var spotReq = new XMLHttpRequest();
      spotReq.onload = function(){
        spot_info = this.responseText.split(",");
        owner = spot_info[0];
        response = '<p>Hello user ' + name + '.</p><p>You have $' + money + '</p><p>This spot is owned by ' + owner;
        response += '<div align="center"><button class="btn btn-primary" onClick="rentConfirm(' + id + ',\'' + username + '\',\'' + money + '\',\'' + owner + '\')">Confirm Rental</button></div></form>';
        spotInfo.update(null,response);
      };
      spotReq.open("get","get_spot_info?id="+id, true);
      spotReq.send();
    };
    userReq.open("get", "get_user_info.php?id="+id, true);
    userReq.send();
    clickListner = false;
//    lockMap();
//    allow_clicks = false;
  }

  function rentConfirm(id, username, money, owner){
    var transReq = new XMLHttpRequest();
    var transData = new FormData();
    transData.append('spot_id', id);
    transData.append('renter', username);
    transData.append('money', money);
    transData.append('owner', owner);
    transReq.onload = function(){
      spotInfo.update(null,'');
      $.post("json_edit.php",{id: id, value: true, renter: username});
      return false;
    };
    transReq.open("post","rental_transaction.php", true);
    transReq.send(transData);
  }

  /*var divIcon = L.divIcon({
    html: "test"
  });
  L.marker(new L.LatLng(0, 0), {icon: divIcon });
  */
  var spotInfo = L.control();

  spotInfo.onAdd = function (map) {
  	this._div = L.DomUtil.create('div', 'spotInfo');
  	this.update();
  	return this._div;
  };

  spotInfo.update = function (properties,addon) {
    occupiedAddition = ' ';
    rentMeButton = '';
    if (typeof properties !== 'undefined' && properties !== null && properties!=''){
      if(!properties.occupied){
        occupiedAddition = 'not ';
        if(!spot_rented){
          rentMeButton = '<div align="center"><button class="btn btn-primary" id="rentMe" onclick="rentSpot('+properties.id+')">Rent Me</button></div>';
        }else{
          rentMeButton = '<div align="center"><button class="btn btn-primary" id="rentMe" onclick="rentSpot('+properties.id+')" disabled>You\'ve already rented a spot!</button></div>';
        }
      }
    }
  	this._div.innerHTML = (properties ?
  		'<h4>This is parking spot number ' + properties.id + '<button class="close" onClick="closePopup()">X</button></h4>' +
      '<p>The spot is ' + occupiedAddition + 'occupied.<br>' + rentMeButton
  		: '') + (addon ? addon : '');
  };

  spotInfo.addTo(map);
  //spotInfo.setPosition('verticalcenterright');

  function closePopup(){
    var blank = '';
    clickListner = false;
    spotInfo.update(blank);
  }

  function lockMap(){
    map.zoomControl.disable();
    map._handlers.forEach(function(handler) {
      handler.disable();
    });
    document.getElementById('map').style.cursor='default';
  }
  function unlockMap(){
    map.zoomControl.enable();
    map._handlers.forEach(function(handler) {
      handler.enable();
    });
    if (map.tap) map.tap.enable();
    document.getElementById('map').style.cursor='grab';
  }

  function spotselectHandler(e) {
    if(allow_clicks){
      var layer = e.target;
      clickLocation = layer.feature.properties.id;
      map.fitBounds(e.target.getBounds());
      if(layer.feature.properties.id == spot_rented_num ){
        spotInfo.update();
        clickListner = false;
      }else{
        clickListner = true;
      }
    }
  //lockMap();

  /*  if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
    	layer.bringToFront();
    }*/
    spotInfo.update(layer.feature.properties);
  }

  function onEachFeature(feature, layer) {
    layer.on({
      click: spotselectHandler
    });
  }

  function style(feature) {
    switch(feature.properties.renter==username_start){
    case false:
      switch (feature.properties.occupied) {
        case true: return {color: "#ff0000", weight: 2};
        case false: return {color: "#27e833", weight: 2};
      }
    break;
    case true:
      spot_rented = true;
      spot_rented_num = feature.properties.id;
      return {color: "#0000ff", weight: 2};
    break;
    }
  }

  var popupContent;
  var realtime = L.realtime({
          url: 'jocklot.json',
          crossOrigin: true,
          type: 'json'
      }, {
          interval: 1 * 1000,
          onEachFeature: onEachFeature,
          style: style
      }).addTo(map);

  realtime.on('update', function(e) {
    if(clickListner){
      var feature = e.features[clickLocation];
      spotInfo.update(feature.properties);
    }

  });

  </script>
<?php endif; ?>
</body>
</html>
