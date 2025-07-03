<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Overview Map/Layer</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<style type="text/css">
		body{
			margin: 0;
		}
		#map{
			width: 100%;
			height: 100vh;
		}
	</style>
</head>
<body>
	<div id="map">
		
	</div>
</body>
<script src='/assets/js/gis/leaflet-omnivore/leaflet-omnivore.min.js'></script>
<script type="text/javascript">
	const map = L.map('map').setView([-3.8316214, 114.8822267], 11);
	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);
	let layersOverlay;
	let setPopUp = (f) =>
	{
		html = '';
		let geo = f.geometry;
		if(geo.type=='Point')
		{
			html += `Latitude : ${geo.coordinates[1]??""}<br>`;
			html += `Longitude : ${geo.coordinates[0]??""}<br>`;
		}
		if(f.properties)
		{
			for(i in f.properties)
			{
				let r = f.properties[i];
				html += `${i} : ${r??""}<br>`;
			}
 		}
 		return html;
	}

	setLayer = L.geoJson(null, {
		onEachFeature: function(f, l) {
			let popup = setPopUp(f);
			l.bindPopup(popup);
		},
		style: function(f) {
			return {
	            weight: 3,
	            color: "#333",
	            dashArray : "5",
	            opacity: 1,
	            fillColor: "#04c8c8",
	            fillOpacity: 0.8
    		};
		},
		pointToLayer: function (f, latlng) {
			let popup = setPopUp(f);
			return L.marker(latlng,{icon:L.icon({
					    iconUrl: '/assets/images/markerinfo.png',
					    iconSize:     [40, 40], 
					})});
		}
	});



	<?php if(isset($_GET['url'])){
		?>
		let layerFile = '<?=$_GET['url']?>';
		let ext = layerFile.split('.').pop();
		if(ext=='geojson')
		{
			layersOverlay =  omnivore.geojson(`${layerFile}`,null,setLayer);
		}
		else if(ext=='csv')
		{
			layersOverlay = omnivore.csv(`${layerFile}`,{
			    latfield: 'lat',
			    lonfield: 'lon',
			    delimiter:';'
			},setLayer);
		}

		layersOverlay.addTo(map).on('ready',
	    	function() {
	        // Get group bounds and center/zoom
	        map.fitBounds(layersOverlay.getBounds());
	    });
		<?php
	}
	?>
	<?php if(isset($_GET['lat']) && isset($_GET['lon'])){ ?>
		layersOverlay = L.marker(['<?=$_GET['lat']?>','<?=$_GET['lon']?>'],{icon:L.icon({
			    iconUrl: '/assets/images/markerinfo.png',
			    iconSize:     [40, 40], 
			})}).addTo(map);
		map.fitBounds(L.latLngBounds([ layersOverlay.getLatLng() ]));
	<?php } ?>

	
</script>


</html>