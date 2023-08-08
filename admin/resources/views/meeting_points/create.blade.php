<x-app-layout :title="__('Create a new Entry')">
    <x-app-container>
        <x-page-title>{{__('Entry Details')}}</x-page-title>
        <form action="{{route('meeting_points.store')}}" method="POST" class="cpt-form">
            @csrf

            <x-form-group name="eventtype" :label="__('Entry Type')" :required="true" :value="old('eventtype')" :fullwidth="true" type="select" :options="['event', 'meetup', 'hike', 'bike']"/>
            <x-form-group name="title" :label="__('Title')" :required="true" :value="old('title')" :fullwidth="true"/>
            <x-form-group name="description" :label="__('Description')" :required="true" :value="old('description')" :fullwidth="true" type="textarea"/>
            <x-form-group name="link" :label="__('Link to chat or form')" :value="old('link')" :fullwidth="true" type="url"/>
            <x-form-group name="meeting_time" :label="__('Meeting Time')" :required="true" :value="old('meeting_time')" :fullwidth="true" type="datetime-local"/>
            <x-form-group onchange="lookupLocation()" name="location" :label="__('Location')" :required="true" :value="old('location')" :fullwidth="true"/>
            <div class="w-full my-6">
                <div id="creation-map" class="aspect-square sm:aspect-16/9 md:aspect-16/7 w-full"></div>
            </div>
            <input type="hidden" name="latitude" id="creation-latitude">
            <input type="hidden" name="longitude" id="creation-longitude">
            <input type="hidden" name="polyline" id="creation-polyline">
            <x-primary-button type="submit">{{__('Create Entry')}}</x-primary-button>
        </form>
    </x-app-container>
</x-app-layout>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" crossorigin="" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script>


const map = L.map('creation-map').fitBounds([[45.7769477403, 6.02260949059], [47.8308275417, 10.4427014502]]);
window.map = map;
window.L = L;
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(map);
let markerLatLong = [
    {{ old('latitude') ?? 46.94648825 }},
    {{ old('longitude') ?? 7.444332430387075 }}
]

var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);
var drawControl = new L.Control.Draw({
    draw: {
        marker: false,
        polygon: false,
        rectangle: false,
        circle: false,
        circlemarker: false
    },
    edit: {
        featureGroup: drawnItems,
        edit: false
    }
});

map.on("draw:created", storePolyline);

function storePolyline(e) {
    let layer = e.layer;
    if (!layer) {
        layer = e.layers.getLayers()[0];
    }
    console.log(layer);
    drawnItems.addLayer(layer);
    let polyline = layer.toGeoJSON();
    document.getElementById('creation-polyline').value = JSON.stringify(polyline);
}

const marker = L.marker(markerLatLong, {
    draggable: true
}).addTo(map);

document.getElementById('creation-latitude').value = markerLatLong[0];
document.getElementById('creation-longitude').value = markerLatLong[1];

marker.on('dragend', function(e) {
    let lat = e.target._latlng.lat;
    let lon = e.target._latlng.lng;
    document.getElementById('creation-latitude').value = lat;
    document.getElementById('creation-longitude').value = lon;
    map.flyTo([lat, lon], 16, {
        animate: true,
        duration: 0.5
    });
    let locationInput = document.querySelector("[name=location]");
    locationInput.setCustomValidity("");
    if (locationInput.previousElementSibling.classList.contains('cpt-alert')) {
        locationInput.previousElementSibling.remove();
    }
});

window.marker = marker;

function typeChange(value) {
    switch (value) {
        case "hike":
        case "bike":
            map.addControl(drawControl);
            document.querySelector("[name=polyline]").required = true;
            break;
        default:
            map.removeControl(drawControl);
            document.querySelector("[name=polyline]").required = false;
            break;
    }
}

document.querySelector("[name=eventtype]").addEventListener('change', function(e) {
    typeChange(e.target.value);
});

</script>

<script>
async function lookupLocation() {
    const L = window.L;
    const map = window.map;
    const marker = window.marker;

    let e = window.event;
    if (e.target.previousElementSibling.classList.contains('cpt-alert')) {
        e.target.previousElementSibling.remove();
    }
    let location = e.target.value;
    let input = e.target;
    input.setCustomValidity("{{__('Please wait...')}}");
    let url = "https://nominatim.openstreetmap.org/search?q=" + location + "&format=json";
    let response = await fetch(url);
    let data = await response.json();
    if (data.length == 0) {
        let alert = document.createElement('div');
        alert.classList.add('cpt-alert');
        alert.classList.add('red');
        alert.innerHTML ="{{__('Sorry, we couldn\'t find that location.')}}";
        input.parentNode.insertBefore(alert, input);
        input.setCustomValidity(`{!!__("Sorry, we couldn't find that location.")!!}`);
        return;
    }
    input.setCustomValidity("");
    let locationData = data[0];
    let lat = locationData.lat;
    let lon = locationData.lon;
    document.getElementById('creation-latitude').value = lat;
    document.getElementById('creation-longitude').value = lon;
    marker.setLatLng([lat, lon]);
    map.flyTo([lat, lon], 16, {
        animate: true,
        duration: 0.5
    });
}
</script>
