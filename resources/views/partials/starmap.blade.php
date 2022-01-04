
@push('header')
	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
	<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
@endpush

	<div class="bodybox">
		<div class="stopside">
			<h1 style="padding: 10px;">Stargazing Sites</h1>
			<div id='listings' class='listings'></div>
		</div>

		<div class="mapside">
			<div id="map" class="rt-map"></div>
		</div>

		<div class="descside">
			<div id='content' style="padding: 0 20px;"></div>
		</div>
	</div>


@push('footer')
<script>

	/* This will let you use the .remove() function later on */
	if (!('remove' in Element.prototype)) {
	  Element.prototype.remove = function() {
	    if (this.parentNode) {
	      this.parentNode.removeChild(this);
	    }
	  };
	}

  mapboxgl.accessToken = 'pk.eyJ1Ijoid2luZGZhbGwiLCJhIjoiYzh4SGtwUSJ9.e79Urn8XNoveVCHCi7IUhQ';

  var map = new mapboxgl.Map({
    container: 'map',
		style: 'mapbox://styles/mapbox/dark-v10',
    //style: 'mapbox://styles/mapbox/light-v10', // old style
		// style: 'mapbox://styles/mapbox/satellite-v9',
    center: [-106.9143165,47.3207382],
    zoom: 6.5,
    scrollZoom: false
  });

	map.addControl(new mapboxgl.NavigationControl());

  var stores = {
  "type": "FeatureCollection",
  "features": [

    @foreach($sites as $stop)

    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [
					{{--
					@php
						$er = json_decode($stop->location);
						$er = [$er];
					@endphp
          {{ $er[0]->latlng->lng}}, // long
          {{ $er[0]->latlng->lat}} // lat
					--}}
					{{$stop->longitude}},
					{{$stop->latitude}}
      ]},
      "properties": {
        "title": "{{$loop->iteration}}. {{ $stop->name }}",
        {{--"image": "/storage/{{ $stop->image }}",
        "credit": "@if(isset($stop->photo_credit))Photo: {!! $stop->photo_credit !!}@endif",
        "content": '{!! $stop->description !!}',--}}
				"region": "{{$stop->region}}",
        "location": "{{ $stop->name }}",
      }
    }@unless($loop->last),@endunless

    @endforeach

  ]
};


stores.features.forEach(function(store, i){
  store.properties.id = i;
});

map.on('click', function(e) {
  /* Determine if a feature in the "locations" layer exists at that point. */
  var features = map.queryRenderedFeatures(e.point, {
    layers: ['locations']
  });

  /* If yes, then: */
  if (features.length) {
    var clickedPoint = features[0];

    /* Fly to the point */
    flyToStore(clickedPoint);

    /* Close all other popups and display popup for clicked store */
    createPopUp(clickedPoint);

    /* Highlight listing in sidebar (and remove highlight for all other listings) */
    var activeItem = document.getElementsByClassName('active');
    if (activeItem[0]) {
      activeItem[0].classList.remove('active');
    }
    var listing = document.getElementById('listing-' + clickedPoint.properties.id);
    listing.classList.add('active');
  }
});

function buildLocationList(data) {
  data.features.forEach(function(store, i){
    /**
     * Create a shortcut for `store.properties`,
     * which will be used several times below.
    **/
    var prop = store.properties;

    /* Add a new listing section to the sidebar. */
    var listings = document.getElementById('listings');
    var listing = listings.appendChild(document.createElement('div'));
    /* Assign a unique `id` to the listing. */
    listing.id = "listing-" + data.features[i].properties.id;
    /* Assign the `item` class to each listing for styling. */
    listing.className = 'item';

    /* Add the link to the individual listing created above. */
    var link = listing.appendChild(document.createElement('a'));
    link.href = '#';
    link.className = 'title';
    link.id = "link-" + prop.id;
    link.innerHTML = prop.title;

    /* Add details to the individual listing. */
    var details = listing.appendChild(document.createElement('div'));
    //details.innerHTML = prop.location;


    /* Fly to point on map when clicked */
    link.addEventListener('click', function(e){
	  for (var i = 0; i < data.features.length; i++) {
	    if (this.id === "link-" + data.features[i].properties.id) {
	      var clickedListing = data.features[i];
	      flyToStore(clickedListing);
	      createPopUp(clickedListing);
	    }
	  }
	  var activeItem = document.getElementsByClassName('active');
	  if (activeItem[0]) {
	    activeItem[0].classList.remove('active');
	  }
	  this.parentNode.classList.add('active');
	});
  });
}

function flyToStore(currentFeature) {
  map.flyTo({
    center: currentFeature.geometry.coordinates,
    zoom: 12
  });
}

function createPopUp(currentFeature) {
	document.getElementById('content').classList.add('-active')
	document.getElementById('content').innerHTML = '<h3>' + currentFeature.properties.title + '</h3>'
{{--		+ '<div class="side-image" style="background-image: url(' + currentFeature.properties.image + '); background-position: center; background-size: cover;">' +
		'</div>' +
		'<span class="-block -padding-10"><strong class="-block -caps -gold -smaller">Description:</strong> ' + currentFeature.properties.content + '</span>'+
		'<span class="-block -padding-10">' + currentFeature.properties.credit + '</span>'--}};



  var popUps = document.getElementsByClassName('mapboxgl-popup');
  /** Check if there is already a popup on the map and if so, remove it */
  if (popUps[0]) popUps[0].remove();

  var popup = new mapboxgl.Popup({ closeOnClick: false, anchor: 'top',maxWidth: '500px',offset: [0, 0]})
    .setLngLat(currentFeature.geometry.coordinates)
    .setHTML('<h3>' + currentFeature.properties.title + '</h3>')
    .addTo(map);
}

map.on('load', function (e) {
  /* Add the data to your map as a layer */
  buildLocationList(stores);

	map.loadImage('/assets/img/star.png',
		(error, image) => {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('star', image);
	});

  map.addLayer({
    "id": "locations",
    "type": "symbol",
    /* Add a GeoJSON source containing place coordinates and information. */
    "source": {
      "type": "geojson",
      "data": stores
    },
		'layout': {
			'icon-image': 'star', // reference the image
			'icon-size': 0.05
		}
  });
});


</script>

@endpush

</body>
</html>
