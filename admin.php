<?php
  include "header/header-control.php";
  if($_SESSION['logon']<3) {
    header("refresh:0; url=index.php");
    echo "USER IS NOT LOGGED ON";
    session_destroy();
    exit;
  }
?>
<html>
<head>
  <title>Admin Page</title>
  <?php if($_SESSION['logon']>=3) {
    include "/header/header-head.php";
    }
    ?>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css"/>
   <link rel="stylesheet" href="/style/admin.css"/>
   <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>
   <script src="js/realtime.js"></script>
</head>
<body>
<?php if($_SESSION['logon']>=3) : ?>
  <?php if($_SESSION['logon']>=3) {
    include "/header/header-body.php";
    }
  ?>

<div class="custom-popup" id="map"></div>
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

var clickListner = false;
var clickLocation = 000;
var features = null;

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

function changeStatus(id,value){
  $.post("reset_parking.php",{spot_num_reset: id});
  alert('completed');
  return false;
}

var divIcon = L.divIcon({
  html: "textToDisplay"
});
L.marker(new L.LatLng(0, 0), {icon: divIcon });

var spotInfo = L.control();

spotInfo.onAdd = function (map) {
	this._div = L.DomUtil.create('div', 'spotInfo');
	this.update();
	return this._div;
};

spotInfo.update = function (properties,addon) {
  if (typeof properties !== 'undefined' && properties !== null && properties!=''){
    switch(properties.occupied){
      case true:
        switch(properties.renter=='-'){
          case true:
            var occupation_status = 'not available';
          break;
          case false:
            var occupation_status = 'rented';
          break;
        }
      break;
      case false:
        var occupation_status = 'available';
      break;
    }
  }
	this._div.innerHTML = (properties ?
		'<h4>This is parking spot number ' + properties.id + '.</h4>' +
    '<p>Current occupation status: <b>' + occupation_status + '</b>.<br>Owner: '+properties.owner+'<br>Renter: '+properties.renter + '</p><div align="center"><button class="btn btn-primary" onclick="changeStatus('+ properties.id + ',' + properties.occupied + ')">Reset this parking space</button></div>'
		: '') + (addon ? addon : '');
};

spotInfo.addTo(map);
//spotInfo.setPosition('verticalcenterright');

/*function lockMap(){
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
}*/

function spotselectHandler(e) {
  var layer = e.target;
  clickLocation = layer.feature.properties.id;
  map.fitBounds(e.target.getBounds());
  clickListner = true;
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
  switch (feature.properties.renter == '-') {
    case true:
      switch(feature.properties.occupied){
        case true:
        return {color: "#ff0000", weight: 2};
        case false:
        return {color: "#27e833", weight: 2};
      }
     break;
    case false:
      switch(feature.properties.occupied){
        case true:
        return {color: "#0000ff", weight: 2};
        case false:
        return {color: "#27e833", weight: 2};
      }
    break;
  }
}

var popupContent;
var realtime = L.realtime({
        url: parking_lot,
        crossOrigin: true,
        type: 'json'
    }, {
        interval: 1 * 1000,
        onEachFeature: onEachFeature,
        style: style
    });
realtime.addTo(map);

realtime.on('update', function(e) {
  features = e.features;
  if(clickListner){
    var feature = e.features[clickLocation];
    spotInfo.update(feature.properties);
  }

});



</script>

<?php endif; ?>

</body>
</html>
